<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230123143817 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE charge (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, part_salarial DOUBLE PRECISION NOT NULL, employer_contribution DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', avantages LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE charge_contract (charge_id INT NOT NULL, contract_id INT NOT NULL, INDEX IDX_4F6794CA55284914 (charge_id), INDEX IDX_4F6794CA2576E0FD (contract_id), PRIMARY KEY(charge_id, contract_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE charge_contract ADD CONSTRAINT FK_4F6794CA55284914 FOREIGN KEY (charge_id) REFERENCES charge (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE charge_contract ADD CONSTRAINT FK_4F6794CA2576E0FD FOREIGN KEY (contract_id) REFERENCES contract (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE charge_contract DROP FOREIGN KEY FK_4F6794CA55284914');
        $this->addSql('ALTER TABLE charge_contract DROP FOREIGN KEY FK_4F6794CA2576E0FD');
        $this->addSql('DROP TABLE charge');
        $this->addSql('DROP TABLE charge_contract');
    }
}
