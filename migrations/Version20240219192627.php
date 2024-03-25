<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240219192627 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE librairie (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE librairie_jeu (librairie_id INT NOT NULL, jeu_id INT NOT NULL, INDEX IDX_BB6B0B6B330C7BB3 (librairie_id), INDEX IDX_BB6B0B6B8C9E392E (jeu_id), PRIMARY KEY(librairie_id, jeu_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE librairie_jeu ADD CONSTRAINT FK_BB6B0B6B330C7BB3 FOREIGN KEY (librairie_id) REFERENCES librairie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE librairie_jeu ADD CONSTRAINT FK_BB6B0B6B8C9E392E FOREIGN KEY (jeu_id) REFERENCES jeu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur ADD librairie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3330C7BB3 FOREIGN KEY (librairie_id) REFERENCES librairie (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B3330C7BB3 ON utilisateur (librairie_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3330C7BB3');
        $this->addSql('ALTER TABLE librairie_jeu DROP FOREIGN KEY FK_BB6B0B6B330C7BB3');
        $this->addSql('ALTER TABLE librairie_jeu DROP FOREIGN KEY FK_BB6B0B6B8C9E392E');
        $this->addSql('DROP TABLE librairie');
        $this->addSql('DROP TABLE librairie_jeu');
        $this->addSql('DROP INDEX UNIQ_1D1C63B3330C7BB3 ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur DROP librairie_id');
    }
}
