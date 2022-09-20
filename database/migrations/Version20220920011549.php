<?php

declare(strict_types=1);

namespace Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220920011549 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE alternatives (id UUID NOT NULL, question_id UUID DEFAULT NULL, name VARCHAR(255) NOT NULL, is_correct BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_46682B545E237E06 ON alternatives (name)');
        $this->addSql('CREATE INDEX IDX_46682B541E27F6BF ON alternatives (question_id)');
        $this->addSql('COMMENT ON COLUMN alternatives.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN alternatives.question_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE questions (id UUID NOT NULL, subject_id UUID DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8ADC54D523EDC87 ON questions (subject_id)');
        $this->addSql('COMMENT ON COLUMN questions.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN questions.subject_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE quizzes (id UUID NOT NULL, student_id UUID DEFAULT NULL, subject VARCHAR(255) NOT NULL, total_questions SMALLINT NOT NULL, score SMALLINT DEFAULT NULL, status VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_94DC9FB5CB944F1A ON quizzes (student_id)');
        $this->addSql('COMMENT ON COLUMN quizzes.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN quizzes.student_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE snapshots (id UUID NOT NULL, quiz_id UUID DEFAULT NULL, student_id UUID DEFAULT NULL, subject_name VARCHAR(255) NOT NULL, question_name VARCHAR(255) NOT NULL, alternative_name VARCHAR(255) NOT NULL, is_correct BOOLEAN NOT NULL, student_alternative BOOLEAN DEFAULT NULL, right_answer BOOLEAN DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4D91463D853CD175 ON snapshots (quiz_id)');
        $this->addSql('CREATE INDEX IDX_4D91463DCB944F1A ON snapshots (student_id)');
        $this->addSql('COMMENT ON COLUMN snapshots.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN snapshots.quiz_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN snapshots.student_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE students (id UUID NOT NULL, name VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN students.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE subjects (id UUID NOT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AB2599175E237E06 ON subjects (name)');
        $this->addSql('COMMENT ON COLUMN subjects.id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE alternatives ADD CONSTRAINT FK_46682B541E27F6BF FOREIGN KEY (question_id) REFERENCES questions (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE questions ADD CONSTRAINT FK_8ADC54D523EDC87 FOREIGN KEY (subject_id) REFERENCES subjects (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE quizzes ADD CONSTRAINT FK_94DC9FB5CB944F1A FOREIGN KEY (student_id) REFERENCES students (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE snapshots ADD CONSTRAINT FK_4D91463D853CD175 FOREIGN KEY (quiz_id) REFERENCES quizzes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE snapshots ADD CONSTRAINT FK_4D91463DCB944F1A FOREIGN KEY (student_id) REFERENCES students (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE alternatives DROP CONSTRAINT FK_46682B541E27F6BF');
        $this->addSql('ALTER TABLE snapshots DROP CONSTRAINT FK_4D91463D853CD175');
        $this->addSql('ALTER TABLE quizzes DROP CONSTRAINT FK_94DC9FB5CB944F1A');
        $this->addSql('ALTER TABLE snapshots DROP CONSTRAINT FK_4D91463DCB944F1A');
        $this->addSql('ALTER TABLE questions DROP CONSTRAINT FK_8ADC54D523EDC87');
        $this->addSql('DROP TABLE alternatives');
        $this->addSql('DROP TABLE questions');
        $this->addSql('DROP TABLE quizzes');
        $this->addSql('DROP TABLE snapshots');
        $this->addSql('DROP TABLE students');
        $this->addSql('DROP TABLE subjects');
    }
}
