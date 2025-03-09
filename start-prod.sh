#!/bin/bash

# Print colorful messages
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
RED='\033[0;31m'
NC='\033[0m' # No Color

echo -e "${BLUE}=== Farm Fusion Production Environment ===${NC}"

# Check if Docker is installed
if ! command -v docker &> /dev/null; then
    echo -e "${RED}Docker is not installed. Please install Docker and try again.${NC}"
    exit 1
fi

# Check if Docker Compose is installed
if ! command -v docker-compose &> /dev/null; then
    echo -e "${RED}Docker Compose is not installed. Please install Docker Compose and try again.${NC}"
    exit 1
fi

# Create .env file if it doesn't exist
if [ ! -f .env ]; then
    echo -e "${YELLOW}Creating .env file from .env.docker...${NC}"
    cp .env.docker .env
fi

# Check for SSL certificates
if [ ! -f docker/nginx/ssl/cert.pem ] || [ ! -f docker/nginx/ssl/key.pem ]; then
    echo -e "${YELLOW}Warning: SSL certificates not found in docker/nginx/ssl/.${NC}"
    echo -e "${YELLOW}For production, you should place your SSL certificates as:${NC}"
    echo -e "${YELLOW}- docker/nginx/ssl/cert.pem${NC}"
    echo -e "${YELLOW}- docker/nginx/ssl/key.pem${NC}"
    echo -e "${YELLOW}Continuing without SSL...${NC}"
    
    # Create directory if it doesn't exist
    mkdir -p docker/nginx/ssl
fi

# Set production environment
echo -e "${BLUE}Setting up production environment...${NC}"
sed -i 's/DOCKER_ENV=.*/DOCKER_ENV=prod/' .env
sed -i 's/APP_ENV=.*/APP_ENV=production/' .env
sed -i 's/NODE_ENV=.*/NODE_ENV=production/' .env

# Build and start the containers
echo -e "${BLUE}Building and starting Docker containers in production mode...${NC}"
docker-compose down
docker-compose build
docker-compose up -d

# Wait for containers to be ready
echo -e "${BLUE}Waiting for containers to be ready...${NC}"
sleep 5

# Run Laravel migrations
echo -e "${BLUE}Running Laravel migrations...${NC}"
docker-compose exec api php artisan migrate --force

# Display access information
echo -e "${GREEN}=== Production environment is ready! ===${NC}"
echo -e "${GREEN}Laravel API: http://localhost/api${NC}"
echo -e "${GREEN}Vue.js App: http://localhost:5173${NC}"
echo -e "${GREEN}Database: localhost:5432 (internal access only)${NC}"

echo -e "${YELLOW}Note: For a true production environment, you should:${NC}"
echo -e "${YELLOW}- Configure proper SSL certificates${NC}"
echo -e "${YELLOW}- Set secure database passwords${NC}"
echo -e "${YELLOW}- Configure proper domain names${NC}"
echo -e "${YELLOW}- Consider using a proper reverse proxy like Traefik or Caddy${NC}"

# Display logs
echo -e "${BLUE}Displaying logs (press Ctrl+C to exit)...${NC}"
docker-compose logs -f 