<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class tables extends Controller
{
    public function GetTables(){
        $data = DB::table('table')->get();
        $reservation = DB::table('order')->get();
        $this->MapReservedPlaces($data, $reservation);
        return view('main')->with(['tables'=>$data]);
    }

    public function GetTable(Request $request){
        $reservation = DB::table('order')->get();
        $data = DB::table('table')->where('number', $request->query('number'))->get();
        $this->MapReservedPlaces($data, $reservation);
        return $data->first();
    }

    public function GetTableView(Request $request){
        $data = DB::table('table')->where('number', $request->query('number'))->first();
        return view('update-table')->with('table', $data);
    }
    public function CreateTable(Request $request){
        DB::table('table')->insert([
            'price'=>$request->input('price'),
            'number'=>$request->input('number'),
            'places'=>$request->input('places'),
        ]);
        return redirect()->back();
    }
    public function GetTablesForAdmin(){
        $data = DB::table('table')->get();
        $reservation = DB::table('order')->get();
        $this->MapReservedPlaces($data, $reservation);
        return view('tables')->with(['tables'=>$data]);
    }
    public function DeleteTable(Request $request){
        DB::table('table')
            ->where('id', $request->query('id'))
            ->delete();
        return redirect()->to('/getTables');
    }
    public function UpdateTable(Request $request){
        DB::table('table')->where('id', $request->query('id'))->update(
            ['price'=>$request->input('price'),
            'number'=>$request->input('number'),
            'places'=>$request->input('places'),
            ]
        );
        return redirect()->back();
    }

    /**
     * @param \Illuminate\Support\Collection $data
     * @param \Illuminate\Support\Collection $reservation
     * @return void
     */
    public function MapReservedPlaces(\Illuminate\Support\Collection $data, \Illuminate\Support\Collection $reservation): void
    {
        $data->mapWithKeys(function ($item) {
            return [$item->reserved_places = 0];
        });
        foreach ($reservation as $order) {
            $data->mapWithKeys(function ($item) use ($order) {
                if ($item->number === $order->table_number
                    && (Carbon::now()->greaterThan($order->reserve_start)
                        && Carbon::now()->lessThan($order->reserve_end))
                ) {
                    if (isset($item->reserved_places)) {
                        return [$item->reserved_places += $order->places];
                    } else {
                        return [$item->reserved_places = $order->places];
                    }
                }
                return [$item];
            });
        }
    }
}
