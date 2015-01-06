-- ----------------------------
-- Table structure for authors
-- ----------------------------
CREATE TABLE IF NOT EXISTS authors (
  id INTEGER CONSTRAINT authors_pKey PRIMARY KEY AUTOINCREMENT,
  firstName VARCHAR(255) NOT NULL,
  lastName VARCHAR(255) NOT NULL
);
