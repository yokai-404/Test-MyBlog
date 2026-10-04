ALTER TABLE migrations
    ADD COLUMN status ENUM('pending', 'running', 'completed', 'failed')
        NOT NULL DEFAULT 'completed'
        AFTER migration;