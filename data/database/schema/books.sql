-- ---------------------------
-- Table structure for books
-- ---------------------------
CREATE TABLE IF NOT EXISTS books (
  id INTEGER CONSTRAINT books_pKey PRIMARY KEY AUTOINCREMENT,
  title VARCHAR(255) NOT NULL,
  isbn VARCHAR(24) NOT NULL,
  publisherId CONSTRAINT publisherId_fKey REFERENCES publishers (id) ON DELETE CASCADE ON UPDATE CASCADE,
  authorId CONSTRAINT authorId_fKey REFERENCES authors (id) ON DELETE CASCADE ON UPDATE CASCADE
);


