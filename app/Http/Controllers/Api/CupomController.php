<?php

namespace CodeDelivery\Http\Controllers\Api;

use CodeDelivery\Repositories\CupomRepository;

use CodeDelivery\Http\Requests;
use CodeDelivery\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class CupomController extends Controller
{


    /**
     * @var CupomRepository
     */
    private $cupomRepository;

    public function __construct(CupomRepository $cupomRepository)
    {
        $this->cupomRepository = $cupomRepository;
    }

    public function show($code)
    {
        return $this->cupomRepository->skipPresenter(false)->findByCode($code);
    }

}
