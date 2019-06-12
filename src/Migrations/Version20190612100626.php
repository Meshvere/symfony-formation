<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190612100626 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql("INSERT INTO tax_rate(id, rate, label) SELECT -1, 0, '0%' FROM tax_rate WHERE id = -1 HAVING COUNT(1) = 0");
        $this->addSql("INSERT INTO tax_rate(rate, label) SELECT 20, '20%' FROM tax_rate WHERE rate = 20 HAVING COUNT(1) = 0");
        $this->addSql("INSERT INTO tax_rate(rate, label) SELECT 10, '10%' FROM tax_rate WHERE rate = 10 HAVING COUNT(1) = 0");
        $this->addSql("INSERT INTO tax_rate(rate, label) SELECT 5.5, '5.5%' FROM tax_rate WHERE rate = 5.5 HAVING COUNT(1) = 0");

        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADFDD13F95 FOREIGN KEY (tax_rate_id) REFERENCES tax_rate (id)');
        $this->addSql('CREATE INDEX IDX_D34A04ADFDD13F95 ON product (tax_rate_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADFDD13F95');
        $this->addSql('DROP INDEX IDX_D34A04ADFDD13F95 ON product');
    }
}
