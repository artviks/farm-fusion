FROM node:20-alpine

# Set working directory
WORKDIR /app

# Copy package.json and package-lock.json
COPY package*.json ./

# Install dependencies
RUN npm install

# Copy application files
COPY . .

# Expose port 5173 for Vite dev server
EXPOSE 5173

# Start development server with explicit host and CORS settings
CMD ["npm", "run", "dev", "--", "--host", "0.0.0.0", "--cors"] 