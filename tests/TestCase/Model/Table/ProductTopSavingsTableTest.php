<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProductTopSavingsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProductTopSavingsTable Test Case
 */
class ProductTopSavingsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProductTopSavingsTable
     */
    public $ProductTopSavings;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ProductTopSavings',
        'app.Vendors',
        'app.Products',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ProductTopSavings') ? [] : ['className' => ProductTopSavingsTable::class];
        $this->ProductTopSavings = TableRegistry::getTableLocator()->get('ProductTopSavings', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ProductTopSavings);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
