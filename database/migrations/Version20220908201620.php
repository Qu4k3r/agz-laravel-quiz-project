<?php

declare(strict_types=1);

namespace Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220908201620 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE answers (id UUID NOT NULL, question_id UUID DEFAULT NULL, name VARCHAR(255) NOT NULL, is_correct BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_50D0C6061E27F6BF ON answers (question_id)');
        $this->addSql('COMMENT ON COLUMN answers.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN answers.question_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE questions (id UUID NOT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN questions.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE quizzes (id UUID NOT NULL, student_id UUID DEFAULT NULL, total_questions SMALLINT NOT NULL, score SMALLINT DEFAULT NULL, status VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_94DC9FB5CB944F1A ON quizzes (student_id)');
        $this->addSql('COMMENT ON COLUMN quizzes.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN quizzes.student_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE students (name VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(name, lastname))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A4698DB2BF396750 ON students (id)');
        $this->addSql('COMMENT ON COLUMN students.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE subjects (id UUID NOT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN subjects.id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE answers ADD CONSTRAINT FK_50D0C6061E27F6BF FOREIGN KEY (question_id) REFERENCES questions (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE quizzes ADD CONSTRAINT FK_94DC9FB5CB944F1A FOREIGN KEY (student_id) REFERENCES students (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE answers DROP CONSTRAINT FK_50D0C6061E27F6BF');
        $this->addSql('ALTER TABLE quizzes DROP CONSTRAINT FK_94DC9FB5CB944F1A');
        $this->addSql('DROP TABLE answers');
        $this->addSql('DROP TABLE questions');
        $this->addSql('DROP TABLE quizzes');
        $this->addSql('DROP TABLE students');
        $this->addSql('DROP TABLE subjects');
    }
}
