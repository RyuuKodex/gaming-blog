<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240122181535 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE article ADD author_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', ADD reviewer_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E6670574616 FOREIGN KEY (reviewer_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_23A0E66F675F31B ON article (author_id)');
        $this->addSql('CREATE INDEX IDX_23A0E6670574616 ON article (reviewer_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66F675F31B');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E6670574616');
        $this->addSql('DROP INDEX IDX_23A0E66F675F31B ON article');
        $this->addSql('DROP INDEX IDX_23A0E6670574616 ON article');
        $this->addSql('ALTER TABLE article DROP author_id, DROP reviewer_id');
    }
}
