-- Create a test database if it doesn't exist
CREATE DATABASE farm_fusion_test WITH OWNER postgres;

-- Connect to the main database
\c farm_fusion_api;

-- Create extensions if needed
CREATE EXTENSION IF NOT EXISTS "uuid-ossp";
CREATE EXTENSION IF NOT EXISTS "pgcrypto";

-- Additional initialization can be added here 