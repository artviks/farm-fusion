#!/bin/bash

# Print colorful messages
GREEN='\033[0;32m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

echo -e "${BLUE}=== Stopping Farm Fusion Development Environment ===${NC}"

# Stop the containers
docker-compose down

echo -e "${GREEN}Development environment has been stopped.${NC}" 