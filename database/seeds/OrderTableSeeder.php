<?php

use Illuminate\Database\Seeder;

class OrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(CodeDelivery\Models\Order::class, 10)->create()->each(function($o){
            for($i=0; $i<=2; $i++){
                $o->items()->save(factory(\CodeDelivery\Models\OrderItem::class)->make([
                    'product_id' => rand(1,5),
                    'qtd' => 2,
                    'price' => 50
                ]));
            }
        });
    }
}
