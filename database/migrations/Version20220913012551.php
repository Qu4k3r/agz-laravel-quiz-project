<?php

declare(strict_types=1);

namespace Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220913012551 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quizzes ALTER generated_questions TYPE jsonb');
        $this->addSql('ALTER TABLE quizzes ALTER generated_questions DROP DEFAULT');
        $this->addSql('ALTER TABLE quizzes ALTER answered_questions TYPE jsonb');
        $this->addSql('ALTER TABLE quizzes ALTER answered_questions DROP DEFAULT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE quizzes ALTER generated_questions TYPE JSONB');
        $this->addSql('ALTER TABLE quizzes ALTER generated_questions DROP DEFAULT');
        $this->addSql('ALTER TABLE quizzes ALTER answered_questions TYPE JSONB');
        $this->addSql('ALTER TABLE quizzes ALTER answered_questions DROP DEFAULT');
    }
}
