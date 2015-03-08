<?php
namespace Bolt\Tests\Storage;

use Bolt\Tests\BoltUnitTest;
use Bolt\Storage\EntityManager;
use Bolt\Storage\Repository;

/**
 * Class to test src/Storage/EntityManager.
 *
 * @author Ross Riley <riley.ross@gmail.com>
 */
class EntityManagerTest extends BoltUnitTest
{
    public function testConnect()
    {
        $app = $this->getApp();
        $em = new EntityManager($app['db'], $app['dispatcher']);
        $this->assertSame($app['db'], \PHPUnit_Framework_Assert::readAttribute($em, 'conn'));
        $this->assertSame($app['dispatcher'], \PHPUnit_Framework_Assert::readAttribute($em, 'eventManager'));        
        
    }
    
    public function testCreateQueryBuilder()
    {
        $app = $this->getApp();
        $em = new EntityManager($app['db'], $app['dispatcher']);
        
        $qb = $em->createQueryBuilder();
        $this->assertInstanceOf('Doctrine\DBAL\Query\QueryBuilder', $qb);
    }
    
    public function testGetRepository()
    {
        $app = $this->getApp();
        $em = new EntityManager($app['db'], $app['dispatcher']);
        
        $repo = $em->getRepository('Bolt\Entity\Users');
        
        $this->assertInstanceOf('Bolt\Storage\Repository', $repo);
    }
    
    public function testGetRepositoryWithAliases()
    {
        $app = $this->getApp();
        $em = new EntityManager($app['db'], $app['dispatcher']);
        
        $customRepoClass = 'Bolt\Tests\Storage\Mock\TestRepository';
        $em->setRepository('Bolt\Entity\Test', $customRepoClass);
        $em->addEntityAlias('test', 'Bolt\Entity\Test');
        
        $repo = $em->getRepository('test');
                
        $this->assertInstanceOf('Bolt\Tests\Storage\Mock\TestRepository', $repo);
    }
    
}
