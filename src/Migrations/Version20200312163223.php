<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200312163223 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE albums MODIFY idAlbum INT NOT NULL');
        $this->addSql('ALTER TABLE albums DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE albums CHANGE idAlbum idAlbum INT NOT NULL');
        $this->addSql('ALTER TABLE albums ADD PRIMARY KEY (idAlbum, idPhotos)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE albums DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE albums CHANGE idAlbum idAlbum INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE albums ADD PRIMARY KEY (idAlbum)');
    }
}
