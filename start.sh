#!/bin/bash

# Print colorful messages
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

echo -e "${BLUE}=== Farm Fusion Development Environment ===${NC}"

# Check if Docker is installed
if ! command -v docker &> /dev/null; then
    echo -e "${YELLOW}Docker is not installed. Please install Docker and try again.${NC}"
    exit 1
fi

# Check if Docker Compose is installed
if ! command -v docker-compose &> /dev/null; then
    echo -e "${YELLOW}Docker Compose is not installed. Please install Docker Compose and try again.${NC}"
    exit 1
fi

# Create .env file if it doesn't exist
if [ ! -f .env ]; then
    echo -e "${YELLOW}Creating .env file from .env.docker...${NC}"
    cp .env.docker .env
fi

# Make sure we're using development settings
echo -e "${BLUE}Setting up development environment...${NC}"
sed -i 's/DOCKER_ENV=.*/DOCKER_ENV=dev/' .env
sed -i 's/APP_ENV=.*/APP_ENV=local/' .env
sed -i 's/NODE_ENV=.*/NODE_ENV=development/' .env

# Create necessary directories
echo -e "${BLUE}Creating necessary directories...${NC}"
mkdir -p docker/nginx/ssl

# Build and start the containers
echo -e "${BLUE}Building and starting Docker containers...${NC}"
docker-compose down
docker-compose build
docker-compose up -d

# Wait for containers to be ready
echo -e "${BLUE}Waiting for containers to be ready...${NC}"
sleep 5

# Run Laravel migrations and seeders
echo -e "${BLUE}Running Laravel migrations...${NC}"
docker-compose exec api php artisan migrate

# Display access information
echo -e "${GREEN}=== Development environment is ready! ===${NC}"
echo -e "${GREEN}Laravel API: http://localhost/api${NC}"
echo -e "${GREEN}Vue.js App: http://localhost:5173${NC}"
echo -e "${GREEN}Database: localhost:5432${NC}"
echo -e "${GREEN}  - Database: ${DB_DATABASE:-farm_fusion_api}${NC}"
echo -e "${GREEN}  - Username: ${DB_USERNAME:-postgres}${NC}"
echo -e "${GREEN}  - Password: ${DB_PASSWORD:-postgres}${NC}"

# Display logs
echo -e "${BLUE}Displaying logs (press Ctrl+C to exit)...${NC}"
docker-compose logs -f
