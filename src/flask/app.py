from flask import Flask, jsonify, request
from flask_cors import CORS
import os

app = Flask(__name__)
CORS(app)

# Configuration from environment variables
app.config['GEMINI_API_KEY'] = os.getenv('GEMINI_API_KEY', '')
app.config['DB_HOST'] = os.getenv('DB_HOST', 'localhost')
app.config['DB_NAME'] = os.getenv('DB_NAME', 'cvgen')
app.config['DB_USER'] = os.getenv('DB_USER', 'cvgen_user')
app.config['DB_PASS'] = os.getenv('DB_PASS', 'cvgen_password')

@app.route('/health', methods=['GET'])
def health():
    """Health check endpoint"""
    return jsonify({
        'status': 'healthy',
        'message': 'Flask API is running'
    }), 200

@app.route('/api/cv', methods=['GET'])
def get_cvs():
    """Get all CVs"""
    return jsonify({
        'status': 'success',
        'message': 'Endpoint is working',
        'data': []
    }), 200

@app.route('/api/cv', methods=['POST'])
def create_cv():
    """Create a new CV"""
    data = request.get_json()
    return jsonify({
        'status': 'success',
        'message': 'CV creation endpoint received',
        'data': data
    }), 201

@app.route('/api/generate', methods=['POST'])
def generate_cv():
    """Generate CV content using Gemini API"""
    data = request.get_json()
    return jsonify({
        'status': 'success',
        'message': 'CV generation endpoint is ready',
        'data': data
    }), 200

@app.errorhandler(404)
def not_found(error):
    """Handle 404 errors"""
    return jsonify({
        'status': 'error',
        'message': 'Endpoint not found'
    }), 404

@app.errorhandler(500)
def internal_error(error):
    """Handle 500 errors"""
    return jsonify({
        'status': 'error',
        'message': 'Internal server error'
    }), 500

if __name__ == '__main__':
    app.run(debug=True, host='0.0.0.0', port=5000)
