<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Http\Controllers\phpqrcode\bindings\tcpdf\qrcode;

include 'phpqrcode/qrlib.php';

class LineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    // include composer autoload
    require_once '../../../vendor/autoload.php';
    
    // เรียกใช้งานสร้าง qrcode โดยสร้าง qrcode 
    // ข้อควม http://www.ninenik.com
    // บันทึกเป็นไฟล์ ชื่อ myqrcode.png ไว้ในโฟลเดอร์ images / picqrcode / myqrcode.png 
    // กำหนด Error Correction ของ QRcode เท่ากับ L  (มีค่า L,M,Q และ H)
    // กำหนด ขนาด pixel เท่ากับ 4
    // กำหนดความหนาของกรอบ เท่ากับ 2
    \PHPQRCode\QRcode::png("http://www.ninenik.com", "images/picqrcode/myqrcode.png", 'L', 4, 2);

        return view('Line.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
