<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230123230448 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contract_tax (contract_id INT NOT NULL, tax_id INT NOT NULL, INDEX IDX_267C2AA42576E0FD (contract_id), INDEX IDX_267C2AA4B2A824D8 (tax_id), PRIMARY KEY(contract_id, tax_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tax (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, sigle VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, percentage DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contract_tax ADD CONSTRAINT FK_267C2AA42576E0FD FOREIGN KEY (contract_id) REFERENCES contract (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contract_tax ADD CONSTRAINT FK_267C2AA4B2A824D8 FOREIGN KEY (tax_id) REFERENCES tax (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contract_tax DROP FOREIGN KEY FK_267C2AA42576E0FD');
        $this->addSql('ALTER TABLE contract_tax DROP FOREIGN KEY FK_267C2AA4B2A824D8');
        $this->addSql('DROP TABLE contract_tax');
        $this->addSql('DROP TABLE tax');
    }
}
