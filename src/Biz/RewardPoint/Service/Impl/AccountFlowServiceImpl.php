<?php

namespace Biz\RewardPoint\Service\Impl;

use Biz\BaseService;
use Biz\RewardPoint\Service\AccountFlowService;
use AppBundle\Common\ArrayToolkit;

class AccountFlowServiceImpl extends BaseService implements AccountFlowService
{
    public function createAccountFlow($flow)
    {
        $flow['sn'] = $this->makeSn();
        $this->validateFields($flow);
        $this->checkUserAccountExist($flow['userId']);
        $flow = $this->filterFields($flow);

        return $this->getAccountFlowDao()->create($flow);
    }

    public function updateAccountFlow($id, $fields)
    {
        if (!empty($fields['userId'])) {
            $this->checkUserAccountExist($fields['userId']);
        }
        $fields = $this->filterFields($fields);

        return $this->getAccountFlowDao()->update($id, $fields);
    }

    public function deleteAccountFlow($id)
    {
        return $this->getAccountFlowDao()->delete($id);
    }

    public function getAccountFlow($id)
    {
        return $this->getAccountFlowDao()->get($id);
    }

    public function searchAccountFlows(array $conditions, $orderBys, $start, $limit)
    {
        return $this->getAccountFlowDao()->search($conditions, $orderBys, $start, $limit);
    }

    public function countAccountFlows(array $conditions)
    {
        return $this->getAccountFlowDao()->count($conditions);
    }

    public function sumAccountOutFlowByUserId($userId)
    {
        return $this->getAccountFlowDao()->sumAccountOutFlowByUserId($userId);
    }

    protected function filterFields($fields)
    {
        return ArrayToolkit::parts(
            $fields,
            array(
                'userId',
                'sn',
                'type',
                'amount',
                'name',
                'operator',
                'note',
            )
        );
    }

    protected function validateFields($fields)
    {
        if (!ArrayToolkit::requireds($fields, array('userId', 'sn', 'type', 'amount', 'operator'))) {
            throw $this->createInvalidArgumentException('Lack of required fields');
        }
    }

    protected function checkUserAccountExist($userId)
    {
        $account = $this->getAccountService()->getAccountByUserId($userId);

        if (empty($account)) {
            throw $this->createNotFoundException("user{$userId}'s account have been opened");
        }
    }

    protected function makeSn()
    {
        return date('YmdHis').rand(10000, 99999);
    }

    protected function getUserService()
    {
        return $this->createService('User:UserService');
    }

    protected function getAccountService()
    {
        return $this->createService('RewardPoint:AccountService');
    }

    protected function getAccountFlowDao()
    {
        return $this->createDao('RewardPoint:AccountFlowDao');
    }
}
