<?php

namespace App\Services;

interface BillServiceInterface
{
    public function create($params);

    public function getBillDetail($id);

    public function getBill($params);

    public function update($id, $status);

    public function getListByUserId($id);

    public function getBillDetailByOrderNo($order_no);

    public function countBillOnDay();

    public function getBillDetailAfterOrder($id);
}
