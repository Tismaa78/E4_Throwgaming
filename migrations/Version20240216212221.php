<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240216212221 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE utilisateur_jeu (utilisateur_id INT NOT NULL, jeu_id INT NOT NULL, INDEX IDX_FA831C6FB88E14F (utilisateur_id), INDEX IDX_FA831C68C9E392E (jeu_id), PRIMARY KEY(utilisateur_id, jeu_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE utilisateur_jeu ADD CONSTRAINT FK_FA831C6FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_jeu ADD CONSTRAINT FK_FA831C68C9E392E FOREIGN KEY (jeu_id) REFERENCES jeu (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur_jeu DROP FOREIGN KEY FK_FA831C6FB88E14F');
        $this->addSql('ALTER TABLE utilisateur_jeu DROP FOREIGN KEY FK_FA831C68C9E392E');
        $this->addSql('DROP TABLE utilisateur_jeu');
    }
}
