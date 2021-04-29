<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210415101128 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE events CHANGE id_member id_member INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ligne_panier ADD id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE planning CHANGE id_coach id_coach INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservations CHANGE id_planning id_planning INT DEFAULT NULL, CHANGE id_member id_member INT DEFAULT NULL');
        $this->addSql('ALTER TABLE vendor CHANGE id_user id_user INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE events CHANGE id_member id_member INT NOT NULL');
        $this->addSql('ALTER TABLE ligne_panier MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE ligne_panier DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE ligne_panier DROP id');
        $this->addSql('ALTER TABLE planning CHANGE id_coach id_coach INT NOT NULL');
        $this->addSql('ALTER TABLE reservations CHANGE id_member id_member INT DEFAULT NULL, CHANGE id_planning id_planning INT NOT NULL');
        $this->addSql('ALTER TABLE vendor CHANGE id_user id_user INT NOT NULL');
    }
}
