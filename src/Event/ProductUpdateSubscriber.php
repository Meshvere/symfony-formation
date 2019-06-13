<?php
declare(strict_types=1);
namespace App\Event;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
final class ProductUpdateSubscriber implements EventSubscriberInterface
{
    /** @var EntityManagerInterface */
    protected $entityManager;
    /** @var LoggerInterface */
    protected $logger;
    public function __construct(
        EntityManagerInterface $entityManager,
        LoggerInterface $logger
    ) {
        $this->entityManager = $entityManager;
        $this->logger = $logger;
    }
    public static function getSubscribedEvents()
    {
        return [
            ProductPreUpdateEvent::NAME => ['onPreUpdate'],
            //ProductPostUpdateEvent::NAME => ['onPostUpdate'],
        ];
    }
    public function onPreUpdate(ProductPreUpdateEvent $event)
    {
        $product = $event->getProduct();
        $unitOfWork = $this->entityManager->getUnitOfWork();
        $unitOfWork->computeChangeSet($this->entityManager->getClassMetadata(Product::class), $product);
        $changeSet = $unitOfWork->getEntityChangeSet($product);
        if (empty($changeSet)) {
            return;
        }
        $this->logger->info(sprintf('Some one is going to update the product with id #%d', $product->getId()), $changeSet);
    }
    //public function onPostUpdate(ProductPostUpdateEvent $event)
    //{
    //    dump($event);
    //}
} 