<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230615093034 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category_user (category_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_608AC0E12469DE2 (category_id), INDEX IDX_608AC0EA76ED395 (user_id), PRIMARY KEY(category_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category_user ADD CONSTRAINT FK_608AC0E12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_user ADD CONSTRAINT FK_608AC0EA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category DROP user_id');
        $this->addSql('ALTER TABLE note ADD category_id_id INT NOT NULL, ADD user_id_id INT NOT NULL, DROP user_id, DROP category_id');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA149777D11E FOREIGN KEY (category_id_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA149D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_CFBDFA149777D11E ON note (category_id_id)');
        $this->addSql('CREATE INDEX IDX_CFBDFA149D86650F ON note (user_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category_user DROP FOREIGN KEY FK_608AC0E12469DE2');
        $this->addSql('ALTER TABLE category_user DROP FOREIGN KEY FK_608AC0EA76ED395');
        $this->addSql('DROP TABLE category_user');
        $this->addSql('ALTER TABLE category ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA149777D11E');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA149D86650F');
        $this->addSql('DROP INDEX IDX_CFBDFA149777D11E ON note');
        $this->addSql('DROP INDEX IDX_CFBDFA149D86650F ON note');
        $this->addSql('ALTER TABLE note ADD user_id INT NOT NULL, ADD category_id INT NOT NULL, DROP category_id_id, DROP user_id_id');
    }
}
