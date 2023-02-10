<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230210100607 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE beers ADD brewery_id INT NOT NULL');
        $this->addSql('ALTER TABLE beers ADD CONSTRAINT FK_B331E638D15C960 FOREIGN KEY (brewery_id) REFERENCES breweries (id)');
        $this->addSql('CREATE INDEX IDX_B331E638D15C960 ON beers (brewery_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE beers DROP FOREIGN KEY FK_B331E638D15C960');
        $this->addSql('DROP INDEX IDX_B331E638D15C960 ON beers');
        $this->addSql('ALTER TABLE beers DROP brewery_id');
    }
}
