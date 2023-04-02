<?php

namespace App\Http\Controllers\Checkout;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Transaction;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function pilihPembayaran(Request $request)
    {
        $cart = Cart::where('user_id', auth()->user()->id)->where('status', 'Checkout')->first();
        $transaksi = Transaction::where('cart_id', $cart->id)->first();
//Mid-server-5Ag52SO4wS7q3JLI0RwdUimr

        \Midtrans\Config::$serverKey = 'SB-Mid-server-FlL7U7f-vg5Dk_rsgI40lDm-';
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        if ($request->post('result_data')) {
            $cartUpdate = Cart::where('user_id', auth()->user()->id)->where('id', $transaksi->cart_id)->first();
            $cartUpdate->update([
                "status" => "Selesai"
            ]);
            $current_status = json_decode($_POST['result_data'], true);
            $order_id = $current_status['order_id'];
            $transaksi = Transaction::where('cart_id', $order_id)->first();
            $transaksi->update([
                "status" => "menunggu pembayaran",
                "metode_pembayaran" => $current_status['va_numbers'][0]['bank']
            ]);

            return redirect()->route('transaksi');
        }

        $params = array(
            'transaction_details' => array(
                'order_id' => $transaksi->id,
                'gross_amount' => $transaksi->total_harga,
            ),
            'customer_details' => array(
                'first_name' => 'Saudara ',
                'last_name' => auth()->user()->name,
                'email' => auth()->user()->email,
                'phone' => '08111222333',
            ),
        );
        $order_id = $params['transaction_details']['order_id'];
        
        $snap_token = \Midtrans\Snap::getSnapToken($params);

        // getSnapToken() adalah fungsi pada library Midtrans yang digunakan untuk membuat token pembayaran (snap token) 
        //dengan mengirimkan data transaksi ke server Midtrans. Snap token adalah token pembayaran yang digunakan untuk membuka
        // halaman pembayaran Midtrans di browse
        return view('frontend.transaksi.pembayaran', compact('snap_token', 'order_id'));
    }

    public function detailTransaksi($id)
    {
        \Midtrans\Config::$serverKey = 'SB-Mid-server-FlL7U7f-vg5Dk_rsgI40lDm-';
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $transaksi = Transaction::findOrFail($id);
        if ($transaksi) {
            $status = \Midtrans\Transaction::status($id);
         //   dd(json_encode($status)); jsonnya
            $status = json_decode(json_encode($status), true);
          //  dd($status);

            if ($transaksi->status == "Barang Diproses" && $transaksi->metode_pembayaran != null) {
                if ($status['transaction_status'] === 'settlement') {
                    $transaksi->update([
                        "status" => "Barang Diproses"
                    ]);
                }
            }

            $ubahStatus = $status['transaction_status'] == 'pending' ? 'Menunggu Pembayaran' : 'Pembayaran Selesai (Barang akan segera di kirim)';
        }
        return view('frontend.transaksi.detail-histori', compact('ubahStatus', 'transaksi', 'status'));
    }
}
