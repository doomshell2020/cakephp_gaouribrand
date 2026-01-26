<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GstsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GstsTable Test Case
 */
class GstsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\GstsTable
     */
    public $Gsts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Gsts',
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
        $config = TableRegistry::getTableLocator()->exists('Gsts') ? [] : ['className' => GstsTable::class];
        $this->Gsts = TableRegistry::getTableLocator()->get('Gsts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Gsts);

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
}
