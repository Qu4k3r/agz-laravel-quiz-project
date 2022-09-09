<?php

declare(strict_types=1);

namespace Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220909024607 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE alternative_questions (id UUID NOT NULL, question_id UUID DEFAULT NULL, name VARCHAR(255) NOT NULL, is_correct BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_354732021E27F6BF ON alternative_questions (question_id)');
        $this->addSql('COMMENT ON COLUMN alternative_questions.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN alternative_questions.question_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE questions (id UUID NOT NULL, subject_id UUID DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8ADC54D523EDC87 ON questions (subject_id)');
        $this->addSql('COMMENT ON COLUMN questions.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN questions.subject_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE quizzes (id UUID NOT NULL, student_id UUID DEFAULT NULL, subject_id UUID DEFAULT NULL, total_questions SMALLINT NOT NULL, score SMALLINT DEFAULT NULL, status VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_94DC9FB5CB944F1A ON quizzes (student_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_94DC9FB523EDC87 ON quizzes (subject_id)');
        $this->addSql('COMMENT ON COLUMN quizzes.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN quizzes.student_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN quizzes.subject_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE students (name VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(name, lastname))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A4698DB2BF396750 ON students (id)');
        $this->addSql('COMMENT ON COLUMN students.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE subjects (id UUID NOT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN subjects.id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE alternative_questions ADD CONSTRAINT FK_354732021E27F6BF FOREIGN KEY (question_id) REFERENCES questions (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE questions ADD CONSTRAINT FK_8ADC54D523EDC87 FOREIGN KEY (subject_id) REFERENCES subjects (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE quizzes ADD CONSTRAINT FK_94DC9FB5CB944F1A FOREIGN KEY (student_id) REFERENCES students (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE quizzes ADD CONSTRAINT FK_94DC9FB523EDC87 FOREIGN KEY (subject_id) REFERENCES subjects (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE alternative_questions DROP CONSTRAINT FK_354732021E27F6BF');
        $this->addSql('ALTER TABLE quizzes DROP CONSTRAINT FK_94DC9FB5CB944F1A');
        $this->addSql('ALTER TABLE questions DROP CONSTRAINT FK_8ADC54D523EDC87');
        $this->addSql('ALTER TABLE quizzes DROP CONSTRAINT FK_94DC9FB523EDC87');
        $this->addSql('DROP TABLE alternative_questions');
        $this->addSql('DROP TABLE questions');
        $this->addSql('DROP TABLE quizzes');
        $this->addSql('DROP TABLE students');
        $this->addSql('DROP TABLE subjects');
    }
}
