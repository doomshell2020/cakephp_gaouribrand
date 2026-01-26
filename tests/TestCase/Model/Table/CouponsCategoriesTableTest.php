<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CouponsCategoriesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CouponsCategoriesTable Test Case
 */
class CouponsCategoriesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CouponsCategoriesTable
     */
    public $CouponsCategories;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.CouponsCategories',
        'app.Coupons',
        'app.Categories',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CouponsCategories') ? [] : ['className' => CouponsCategoriesTable::class];
        $this->CouponsCategories = TableRegistry::getTableLocator()->get('CouponsCategories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CouponsCategories);

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
