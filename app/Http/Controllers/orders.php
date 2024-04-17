<?php

namespace App\Http\Controllers;

use App\Mail\ReservationMail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class orders extends Controller
{
    public function CreateOrder(Request $request)
    {
        $isPlaceExist = DB::table('table')
            ->where('number', $request->input('number'))->first();
        $reserved = DB::table('order')
            ->where('table_number', $request->input('number'))
            ->get();
        $reserved_places = 0;
        foreach ($reserved as $item) {
            if (Carbon::now()->greaterThan($item->reserve_start)
                && Carbon::now()->lessThan($item->reserve_end)){
                    $reserved_places += $item->places;
                }
        }
        if ($isPlaceExist->places - $reserved_places >= $request->input('places')){
            DB::table('order')->insert([
                'phone'=>$request->input('phone'),
                'wish'=>$request->input('wish'),
                'name'=>$request->input('name'),
                'table_number'=>$request->input('number'),
                'reserve_start'=>Carbon::now(),
                'reserve_end'=>Carbon::now()->addMinutes(3),
                'places'=>$request->input('places')
            ]);
            $title = 'Новая бронь!';
            $body = 'Имя: '.$request->input('name').
                '; Номер столика: #'.$request->input('number').
                '; Кол-во мест: '.$request->input('places').
                '; Телефон для связи: '.$request->input('phone').
                '; Пожелание к брони: '.$request->input('wish');

            Mail::to('vladn803@gmail.com')->send(new ReservationMail($title, $body));
            return redirect()->back();
        }else{
            return redirect()->back()->withErrors(['errors' => 'Места за этим столиком уже кончились']);
        }
    }
    public function GetOrders(){
        $data = DB::table('order')->get();
        $tables = DB::table('table')->get();
        return view('orders')->with('orders',$data)->with('tables',$tables);
    }
    public function GetOrder(Request $request){
        $data = DB::table('order')->where('id', $request->query('id'))->get();
        return $data;
    }
    public function UpdateOrder(Request $request){

        DB::table('order')->where('id', $request->query('id'))->update(
            [
                'table_number'=>$request->input('number'),
                'reserve_start'=>$request->input('reserve_start'),
                'reserve_end'=>$request->input('reserve_end'),
                'places'=>$request->input('places')
            ]
        );
        return redirect()->back();
    }
    public function DeleteOrder(Request $request){
        DB::table('order')->where('id', $request->query('id'))->delete();
        return redirect()->back();
    }
}
