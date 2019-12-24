<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191128111708 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE specialite (id INT AUTO_INCREMENT NOT NULL, service_id INT NOT NULL, libelle VARCHAR(255) NOT NULL, INDEX IDX_E7D6FCC1ED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE specialite_medcin (specialite_id INT NOT NULL, medcin_id INT NOT NULL, INDEX IDX_88E95202195E0F0 (specialite_id), INDEX IDX_88E9520F46C40AE (medcin_id), PRIMARY KEY(specialite_id, medcin_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE specialite ADD CONSTRAINT FK_E7D6FCC1ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE specialite_medcin ADD CONSTRAINT FK_88E95202195E0F0 FOREIGN KEY (specialite_id) REFERENCES specialite (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE specialite_medcin ADD CONSTRAINT FK_88E9520F46C40AE FOREIGN KEY (medcin_id) REFERENCES medcin (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE medcin ADD prenom VARCHAR(255) NOT NULL, ADD nom VARCHAR(255) NOT NULL, ADD tel VARCHAR(255) NOT NULL, ADD datenais VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE specialite_medcin DROP FOREIGN KEY FK_88E95202195E0F0');
        $this->addSql('DROP TABLE specialite');
        $this->addSql('DROP TABLE specialite_medcin');
        $this->addSql('ALTER TABLE medcin DROP prenom, DROP nom, DROP tel, DROP datenais');
    }
}
