<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200506163726 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE director (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, picture VARCHAR(255) DEFAULT NULL, nationality VARCHAR(255) DEFAULT NULL, bio CLOB DEFAULT NULL, birthday DATE DEFAULT NULL)');
        $this->addSql('CREATE TABLE actor (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, picture VARCHAR(255) DEFAULT NULL, nationality VARCHAR(255) DEFAULT NULL, bio CLOB DEFAULT NULL, birthday DATE DEFAULT NULL)');
        $this->addSql('CREATE TABLE actor_movie (actor_id INTEGER NOT NULL, movie_id INTEGER NOT NULL, PRIMARY KEY(actor_id, movie_id))');
        $this->addSql('CREATE INDEX IDX_39DA19FB10DAF24A ON actor_movie (actor_id)');
        $this->addSql('CREATE INDEX IDX_39DA19FB8F93B6FC ON actor_movie (movie_id)');
        $this->addSql('CREATE TABLE review (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, movie_id INTEGER NOT NULL, content CLOB NOT NULL)');
        $this->addSql('CREATE INDEX IDX_794381C68F93B6FC ON review (movie_id)');
        $this->addSql('CREATE TABLE rate (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, movie_id INTEGER NOT NULL, value SMALLINT NOT NULL)');
        $this->addSql('CREATE INDEX IDX_DFEC3F398F93B6FC ON rate (movie_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__movie AS SELECT id, title, pitch, poster FROM movie');
        $this->addSql('DROP TABLE movie');
        $this->addSql('CREATE TABLE movie (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, director_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, pitch CLOB DEFAULT NULL COLLATE BINARY, poster VARCHAR(255) DEFAULT NULL COLLATE BINARY, CONSTRAINT FK_1D5EF26F899FB366 FOREIGN KEY (director_id) REFERENCES director (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO movie (id, title, pitch, poster) SELECT id, title, pitch, poster FROM __temp__movie');
        $this->addSql('DROP TABLE __temp__movie');
        $this->addSql('CREATE INDEX IDX_1D5EF26F899FB366 ON movie (director_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE director');
        $this->addSql('DROP TABLE actor');
        $this->addSql('DROP TABLE actor_movie');
        $this->addSql('DROP TABLE review');
        $this->addSql('DROP TABLE rate');
        $this->addSql('DROP INDEX IDX_1D5EF26F899FB366');
        $this->addSql('CREATE TEMPORARY TABLE __temp__movie AS SELECT id, title, pitch, poster FROM movie');
        $this->addSql('DROP TABLE movie');
        $this->addSql('CREATE TABLE movie (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, pitch CLOB DEFAULT NULL, poster VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO movie (id, title, pitch, poster) SELECT id, title, pitch, poster FROM __temp__movie');
        $this->addSql('DROP TABLE __temp__movie');
    }
}
