-- Phase 2: Observer Pattern — notifications table
-- Run once against padel_db

CREATE TABLE IF NOT EXISTS notifications (
    id         INT          AUTO_INCREMENT PRIMARY KEY,
    type       VARCHAR(20)  NOT NULL COMMENT 'admin | user',
    user_id    INT          NULL     COMMENT 'NULL = admin-level notification',
    message    TEXT         NOT NULL,
    is_read    TINYINT(1)   NOT NULL DEFAULT 0,
    created_at TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_user_unread (user_id, is_read),
    INDEX idx_type        (type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
