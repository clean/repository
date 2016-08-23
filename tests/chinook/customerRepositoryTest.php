<?php namespace Test\Clean\Example\Chinook\Customer\Repository;

use Example\Chinook\Customers\Repository as CustomerRepository;

use Clean\Repository\CacheProxy as CacheProxy;
use Clean\Repository\CacheAdapter\Metaphore as CacheAdapter;
use Metaphore\Cache as Cache;
use Metaphore\Store\MockStore as MockStore;

class TestCase extends \PHPUnit_Framework_TestCase
{
    public function testGettingCustomers()
    {
        $repository = new CustomerRepository();
        $data = $repository
            ->limit(4)
            ->assemble();

        $this->assertEquals(4, $data->count());
    }

    public function testGettingCustomersFilterByIds()
    {
        $repository = new CustomerRepository();
        $ids = [1,2,5];
        $invalid_ids = [100,200];
        $data = $repository
            ->filterById(array_merge($ids, $invalid_ids))
            ->assemble();

        $this->assertEquals(3, $data->count());
        foreach ($data as $customer) {
            $this->assertTrue(in_array($customer->customerId, $ids));
        }
    }

    public function testGettingCustomersByWrongId()
    {
        $repository = new CustomerRepository();
        $invalid_ids = [100,200];
        $data = $repository
            ->filterById($invalid_ids)
            ->assemble();

        $this->assertEquals(0, $data->count());
    }

    public function testGettingCustomersByCountry()
    {
        $repository = new CustomerRepository();
        $country = ['Canada','Brazil'];
        $data = $repository
            ->filterByCountry($country)
            ->assemble();

        $this->assertEquals(13, $data->count());
    }
}
