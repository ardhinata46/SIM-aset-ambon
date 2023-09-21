<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UbahKataSandi extends Mailable
{

    use Queueable,
        SerializesModels;

    var $nama = "";
    var $link = "";

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nama, $link)
    {
        $this->nama = $nama;
        $this->link = $link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = array(
            'nama' => $this->nama,
            'link' => $this->link
        );

        return $this->from('gpibiaa.k@gmail.com')->view('mail/reset')->with(['data' => $data]);
    }
}
