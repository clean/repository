<?php namespace Example\Chinook\Customers;

use Example\Chinook\AbstractRepository;

class Repository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct();
        $this->getBaseCriteria()
            ->cols([
                'CustomerId' => 'customerId',
                'FirstName' => 'firstName',
                'LastName' => 'lastName',
                'Company' => 'company',
                'Address' => 'address',
                'City' => 'city',
                'State' => 'state',
                'Country' => 'country',
                'PostalCode' => 'postalCode',
                'Phone' => 'phone',
                'Fax' => 'fax',
                'Email' => 'email',
                'SupportRepId' => 'supportRepId',
            ])
            ->from('customers');
    }

    public function assemble()
    {
        $collection = parent::assemble();

        return $collection;
    }

    /**
     * Returns customers with given ids
     * 
     * @param array $ids Customers ids 
     * 
     * @return self
     */
    public function filterById(array $ids)
    {
        $this->getBaseCriteria()
            ->where('customerId IN (:filterByCustomerId)')
            ->bindValues([
                'filterByCustomerId' => $ids,
            ])
        ;

        return $this;
    }

    /**
     * Returns customers filter by country name
     * 
     * @param string $name Country name
     * 
     * @return self
     */
    public function filterByCountry(array $name)
    {
        $this->getBaseCriteria()
            ->where('country IN (:filterByCountry)')
            ->bindValues([
                'filterByCountry' => $name,
            ])
        ;

        return $this;
    }
}
