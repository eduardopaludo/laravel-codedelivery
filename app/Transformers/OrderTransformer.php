<?php

namespace CodeDelivery\Transformers;

use Illuminate\Database\Eloquent\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;
use CodeDelivery\Models\Order;

/**
 * Class OrderTransformer
 * @package namespace CodeDelivery\Transformers;
 */
class OrderTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['cupom', 'items', 'client'];
    //protected $availableIncludes = [];

    /**
     * Transform the \Order entity
     * @param \Order $model
     *
     * @return array
     */
    public function transform(Order $model)
    {
        return [
            'id'         => (int) $model->id,
            'total'     =>  (float) $model->total,
            'product_names' => $this->getArrayProductName($model->items),
            'status' => $model->status,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }

    protected function getArrayProductName(Collection $items)
    {
        $names = [];
        foreach ($items as $item)
        {
            $names[] = $item->product->name;
        }
        return $names;
    }


    public function includeClient(Order $model)
    {
        return $this->item($model->client, new ClientTransformer());
    }
    public function includeCupom(Order $model)
    {
        if(!$model->cupom)
        {
            return null;
        }
        return $this->item($model->cupom, new CupomTransformer());
    }

    public function includeItems(Order $model)
    {
        return $this->collection($model->items, new OrderItemTransformer());
    }
}
