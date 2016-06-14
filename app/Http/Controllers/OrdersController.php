<?php
/**
 * Created by PhpStorm.
 * User: eduar
 * Date: 6/13/2016
 * Time: 7:14 PM
 */

namespace CodeDelivery\Http\Controllers;


use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\UserRepository;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * @var OrderRepository
     */
    private $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {

        $this->orderRepository = $orderRepository;
    }

    public function index()
    {
        $orders = $this->orderRepository->paginate();

        return view('admin.orders.index', compact('orders'));
    }

    public function edit($id, UserRepository $userRepository)
    {
        $list_status = [0=>'Pendente', 1=>'A caminho', 2=>'Entregue', 3=>'Cancelado'];
        $order = $this->orderRepository->find($id);

        $deliveryman = $userRepository->getDeliveryMen();

        return view('admin.orders.edit', compact('order', 'list_status', 'deliveryman'));
    }

    public function update(Request $request, $id)
    {
        $all = $request->all();
        $this->orderRepository->update($all, $id);

        return redirect()->route('admin.orders.index');
    }
}