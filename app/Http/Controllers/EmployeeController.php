<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::paginate(10);  // paginate 10 data per halaman
        return view('employees.index', compact('employees'));
    }


    public function store(Request $request)
    {
        // Validasi sederhana
        $request->validate([
            'nip' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'pangkat' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string',
        ]);

        Employee::create($request->all());

        return redirect()->route('employees.index')->with('success', 'Pegawai berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nip' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'pangkat' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string',
        ]);

        $employee = Employee::findOrFail($id);
        $employee->update($request->all());

        return redirect()->route('employees.index')->with('success', 'Pegawai berhasil diupdate');
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Pegawai berhasil dihapus');
    }

    public function create()
    {
        return view('employees.create');  // pastikan kamu sudah punya file view ini
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        return view('employees.edit', compact('employee'));
    }

    // public function sip()
    // {
    //     $employees = Employee::where('jenis_pegawai', 'Tenaga Medis')->paginate(10);
    //     return view('sips.sip', compact('employees'));
    // }

    public function allsip(Request $request)
    {
        $search = $request->input('search');

        $employees = Employee::where('jenis_pegawai', 'Tenaga Medis')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%")
                        ->orWhere('nip', 'like', "%{$search}%")
                        ->orWhere('no_sip', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->paginate(10);

        return view('sips.allsip', compact('employees', 'search'));
    }



    public function sip(Request $request)
    {
        $query = Employee::where('jenis_pegawai', 'Tenaga Medis');

        // Filter pencarian jika ada
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%$search%")
                    ->orWhere('nip', 'like', "%$search%")
                    ->orWhere('no_sip', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            });
        }

        // Filter SIP yang akan expired dalam 6 bulan ke depan
        $sixMonthsFromNow = Carbon::now()->addMonths(6);
        $query->whereDate('tanggal_kadaluwarsa', '<=', $sixMonthsFromNow);
        $query->orderBy('tanggal_kadaluwarsa', 'asc');


        $employees = $query->paginate(10);


        return view('sips.sip', compact('employees'));
    }

    public function sendEmailMassal()
    {
        $today = \Carbon\Carbon::today();
        $sixMonthsFromNow = $today->copy()->addMonths(6);

        $employees = Employee::where('jenis_pegawai', 'Tenaga Medis')
            ->whereNotNull('email')
            ->whereDate('tanggal_kadaluwarsa', '<=', $sixMonthsFromNow)
            // jika yang telah kadaluarsa tidak ingin dikirim email juga
            // ->whereDate('tanggal_kadaluwarsa', '>=', Carbon::now())
            ->get();

        $count = 0;

        foreach ($employees as $employee) {
            try {
                $tanggal = \Carbon\Carbon::parse($employee->tanggal_kadaluwarsa)->format('d-m-Y');
                $isExpired = \Carbon\Carbon::parse($employee->tanggal_kadaluwarsa)->lt($today);

                // Tentukan subject dan body berdasarkan status kadaluarsa
                if ($isExpired) {
                    $subject = "Pengingat: SIP Telah Kadaluarsa";
                    $body = "Yth. {$employee->nama},\n\n" .
                        "SIP Anda dengan nomor {$employee->no_sip} telah kedaluwarsa pada {$tanggal}.\n" .
                        "Segera lakukan perpanjangan jika belum.\n\n" .
                        "Terima kasih.";
                } else {
                    $subject = "Pengingat: SIP Akan Kadaluarsa";
                    $body = "Yth. {$employee->nama},\n\n" .
                        "SIP Anda dengan nomor {$employee->no_sip} akan kedaluwarsa pada {$tanggal}.\n" .
                        "Silakan lakukan perpanjangan tepat waktu.\n\n" .
                        "Terima kasih.";
                }

                Mail::raw($body, function ($message) use ($employee, $subject) {
                    $message->to($employee->email)
                        ->subject($subject);
                });

                Log::info("✅ Email terkirim ke: {$employee->email}");
                $count++;
            } catch (\Exception $e) {
                Log::error("❌ Gagal kirim email ke {$employee->email}: " . $e->getMessage());
            }
        }

        Session::flash('success', "✅ Berhasil mengirim email ke {$count} pegawai.");
        return redirect()->back();
    }

    public function sendRekapEmail()
    {
        $today = Carbon::today();
        $sixMonthsFromNow = $today->copy()->addMonths(6);
        $pastLimit = $today->copy()->subDays(30); // Tambahkan yang sudah kadaluarsa 1 bulan ke belakang

        $employees = Employee::where('jenis_pegawai', 'Tenaga Medis')
            ->whereBetween('tanggal_kadaluwarsa', [$pastLimit, $sixMonthsFromNow])
            ->orderBy('tanggal_kadaluwarsa')
            ->get();

        if ($employees->isEmpty()) {
            return redirect()->back()->with('warning', '⚠️ Tidak ada data SIP yang akan/telah kadaluarsa.');
        }

        $rows = '';

        foreach ($employees as $emp) {
            $nama = $emp->nama;
            $nip = $emp->nip;
            $noSIP = $emp->no_sip ?? '-';
            $expiredDate = Carbon::parse($emp->tanggal_kadaluwarsa);
            $formattedDate = $expiredDate->format('d-m-Y');

            if ($expiredDate->greaterThan($today)) {
                $diff = $today->diff($expiredDate); // DateInterval
                $months = $diff->m + ($diff->y * 12);
                $days = $diff->d;

                $sisaText = $months > 0 ? "{$months} bulan {$days} hari lagi" : "{$days} hari lagi";
                $status = "AKAN KADALUWARSA";
                $bgColor = "#fff3cd"; // kuning muda

            } elseif ($expiredDate->equalTo($today)) {
                $sisaText = "hari ini";
                $status = "AKAN KADALUWARSA";
                $bgColor = "#fff3cd";
            } else {
                $diff = $expiredDate->diff($today); // DateInterval
                $months = $diff->m + ($diff->y * 12);
                $days = $diff->d;

                $sisaText = $months > 0 ? "{$months} bulan {$days} hari yang lalu" : "{$days} hari yang lalu";
                $status = "KADALUWARSA";
                $bgColor = "#f8d7da"; // merah muda
            }

            $rows .= "
                <tr style='background-color: {$bgColor};'>
                    <td>{$nama}</td>
                    <td>{$nip}</td>
                    <td>{$noSIP}</td>
                    <td>{$formattedDate}</td>
                    <td>{$sisaText}</td>
                    <td><strong>{$status}</strong></td>
                </tr>
            ";
        }

        $htmlBody = "
            <html>
            <body>
                <p>📋 Berikut adalah rekap pegawai dengan SIP yang akan atau telah kadaluarsa:</p>
                <table border='1' cellpadding='8' cellspacing='0' style='border-collapse: collapse; font-family: Arial; font-size: 14px; width: 100%;'>
                    <thead style='background-color: #cce5ff;'>
                        <tr>
                            <th>Nama</th>
                            <th>NIP</th>
                            <th>No SIP</th>
                            <th>Tanggal Expired</th>
                            <th>Sisa Waktu</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        {$rows}
                    </tbody>
                </table>
                <br>
                <p>Harap segera ditindaklanjuti.</p>
            </body>
            </html>
        ";

        $adminEmail = "abieperdanakusuma@gmail.com";

        Mail::send([], [], function ($message) use ($adminEmail, $htmlBody) {
            $message->to($adminEmail)
                ->subject('📋 Rekap SIP Akan/Telah Kadaluarsa')
                ->html($htmlBody);
        });

        return redirect()->back()->with('success', '📧 Rekap berhasil dikirim ke email admin.');
    }

    private function sendTelegram($chatId, $htmlMessage)
    {
        $token = '7614554370:AAFsoKR5UG-GLKHSUzM8Jwr63Ju8Oz1ebeQ';
        $url = "https://api.telegram.org/bot{$token}/sendMessage";

        $response = Http::asForm()->post($url, [
            'chat_id' => $chatId,
            'text' => $htmlMessage,
            'parse_mode' => 'HTML'
        ]);

        return $response->successful();
    }

    public function sendRekapTelegram()
    {
        $today = Carbon::today();
        $sixMonthsFromNow = $today->copy()->addMonths(6);
        $pastLimit = $today->copy()->subDays(30); // Include max 1 bulan yang sudah lewat

        $sips = Employee::where('jenis_pegawai', 'Tenaga Medis')
            ->whereBetween('tanggal_kadaluwarsa', [$pastLimit, $sixMonthsFromNow])
            ->orderBy('tanggal_kadaluwarsa')
            ->get();

        if ($sips->isEmpty()) {
            return redirect()->back()->with('warning', '✅ Tidak ada SIP yang akan atau telah expired.');
        }

        $message = "<b>📋 REKAP SIP YANG AKAN/TELAH EXPIRED</b>\n";
        $message .= "Per tanggal <b>" . $today->format('d-m-Y') . "</b>\n\n";
        $message .= "<pre>";
        $message .= str_pad("Nama", 18) . str_pad("No SIP", 15) . str_pad("Tgl Exp", 13) . "Sisa Hari\n";
        $message .= str_repeat("-", 58) . "\n";

        foreach ($sips as $sip) {
            $nama = str_replace(['<', '>', '&'], '', $sip->nama); // escape basic HTML
            $noSIP = $sip->no_sip ?? '-';
            $expiredDate = Carbon::parse($sip->tanggal_kadaluwarsa);
            $tglExp = $expiredDate->format('d-m-Y');

            if ($expiredDate->equalTo($today)) {
                $sisaText = "hari ini";
            } elseif ($expiredDate->greaterThan($today)) {
                $diff = $today->diff($expiredDate); // DateInterval
                $months = $diff->m + ($diff->y * 12);
                $days = $diff->d;
                $sisaText = "{$months} bln {$days} hr";
            } else {
                $diff = $expiredDate->diff($today); // DateInterval
                $months = $diff->m + ($diff->y * 12);
                $days = $diff->d;
                $sisaText = $months > 0
                    ? "{$months} bln {$days} hr yang lalu"
                    : "{$days} hari yang lalu";
            }

            $message .= str_pad(substr($nama, 0, 17), 18);
            $message .= str_pad($noSIP, 15);
            $message .= str_pad($tglExp, 13);
            $message .= $sisaText . "\n";
        }

        $message .= "</pre>";

        $chatIds = ['430878024', '5829131684'];
        foreach ($chatIds as $chatId) {
            $this->sendTelegram($chatId, $message);
        }

        return redirect()->back()->with('success', '📲 Rekap berhasil dikirim ke Telegram.');
    }
}
