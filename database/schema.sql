CREATE TABLE categories (
                            id INT AUTO_INCREMENT PRIMARY KEY,
                            name VARCHAR(255) NOT NULL,
                            description TEXT,
                            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE posts (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       title VARCHAR(255) NOT NULL,
                       image VARCHAR(255),
                       description TEXT,
                       content TEXT,
                       views_count INT DEFAULT 0,
                       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE post_category (
                               post_id INT,
                               category_id INT,
                               PRIMARY KEY (post_id, category_id),
                               FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
                               FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);
