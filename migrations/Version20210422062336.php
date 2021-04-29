<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210422062336 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande CHANGE id_vendor id_vendor INT DEFAULT NULL');
        $this->addSql('ALTER TABLE panier CHANGE id_product id_product INT DEFAULT NULL, CHANGE id_user id_user INT DEFAULT NULL, CHANGE total total INT DEFAULT NULL');
        $this->addSql('ALTER TABLE planning CHANGE nbrActuel nbrActuel INT DEFAULT NULL');
        $this->addSql('ALTER TABLE produits CHANGE id_vendor id_vendor INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reclamation CHANGE answer answer VARCHAR(255) DEFAULT \'NULL\', CHANGE date date DATE DEFAULT \'NULL\', CHANGE archive archive VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE reservations CHANGE id_coach id_coach INT DEFAULT NULL, CHANGE date_reservation date_reservation DATE DEFAULT \'NULL\', CHANGE etat etat VARCHAR(10) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE suggestion CHANGE answer answer VARCHAR(255) DEFAULT \'NULL\', CHANGE date date DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL, ADD slug VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649989D9B62 ON user (slug)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande CHANGE id_vendor id_vendor INT DEFAULT NULL');
        $this->addSql('ALTER TABLE panier CHANGE id_product id_product INT DEFAULT NULL, CHANGE id_user id_user INT DEFAULT NULL, CHANGE total total INT DEFAULT NULL');
        $this->addSql('ALTER TABLE planning CHANGE nbrActuel nbrActuel INT DEFAULT NULL');
        $this->addSql('ALTER TABLE produits CHANGE id_vendor id_vendor INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reclamation CHANGE answer answer VARCHAR(255) CHARACTER SET latin1 DEFAULT NULL COLLATE `latin1_swedish_ci`, CHANGE date date DATE DEFAULT NULL, CHANGE archive archive VARCHAR(255) CHARACTER SET latin1 DEFAULT NULL COLLATE `latin1_swedish_ci`');
        $this->addSql('ALTER TABLE reservations CHANGE id_coach id_coach INT DEFAULT NULL, CHANGE date_reservation date_reservation DATE DEFAULT NULL, CHANGE etat etat VARCHAR(10) CHARACTER SET latin1 DEFAULT NULL COLLATE `latin1_swedish_ci`');
        $this->addSql('ALTER TABLE suggestion CHANGE answer answer VARCHAR(255) CHARACTER SET latin1 DEFAULT NULL COLLATE `latin1_swedish_ci`, CHANGE date date DATE DEFAULT NULL');
        $this->addSql('DROP INDEX UNIQ_8D93D649989D9B62 ON user');
        $this->addSql('ALTER TABLE user DROP created_at, DROP updated_at, DROP slug');
    }
}
