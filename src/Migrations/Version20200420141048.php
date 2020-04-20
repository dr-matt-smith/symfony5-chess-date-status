<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200420141048 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_result (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chess_game (id INT AUTO_INCREMENT NOT NULL, player1_white_id INT DEFAULT NULL, player2_black_id INT DEFAULT NULL, result_id INT DEFAULT NULL, start_date_time DATETIME NOT NULL, completed TINYINT(1) NOT NULL, INDEX IDX_4EF059358C5D0276 (player1_white_id), INDEX IDX_4EF0593579321CE5 (player2_black_id), INDEX IDX_4EF059357A7B643 (result_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, steps VARCHAR(255) NOT NULL, time INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE chess_game ADD CONSTRAINT FK_4EF059358C5D0276 FOREIGN KEY (player1_white_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE chess_game ADD CONSTRAINT FK_4EF0593579321CE5 FOREIGN KEY (player2_black_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE chess_game ADD CONSTRAINT FK_4EF059357A7B643 FOREIGN KEY (result_id) REFERENCES game_result (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE chess_game DROP FOREIGN KEY FK_4EF059358C5D0276');
        $this->addSql('ALTER TABLE chess_game DROP FOREIGN KEY FK_4EF0593579321CE5');
        $this->addSql('ALTER TABLE chess_game DROP FOREIGN KEY FK_4EF059357A7B643');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE game_result');
        $this->addSql('DROP TABLE chess_game');
        $this->addSql('DROP TABLE recipe');
    }
}
