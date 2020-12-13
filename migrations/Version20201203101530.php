<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201203101530 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE competence_niveau');
        $this->addSql('ALTER TABLE groupe_competence ADD libelle VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE niveau ADD competence_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE niveau ADD CONSTRAINT FK_4BDFF36B15761DAB FOREIGN KEY (competence_id) REFERENCES competence (id)');
        $this->addSql('CREATE INDEX IDX_4BDFF36B15761DAB ON niveau (competence_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE competence_niveau (competence_id INT NOT NULL, niveau_id INT NOT NULL, INDEX IDX_23C9677B3E9C81 (niveau_id), INDEX IDX_23C967715761DAB (competence_id), PRIMARY KEY(competence_id, niveau_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE competence_niveau ADD CONSTRAINT FK_23C967715761DAB FOREIGN KEY (competence_id) REFERENCES competence (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE competence_niveau ADD CONSTRAINT FK_23C9677B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_competence DROP libelle');
        $this->addSql('ALTER TABLE niveau DROP FOREIGN KEY FK_4BDFF36B15761DAB');
        $this->addSql('DROP INDEX IDX_4BDFF36B15761DAB ON niveau');
        $this->addSql('ALTER TABLE niveau DROP competence_id');
    }
}
