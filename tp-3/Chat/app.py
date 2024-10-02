from flask import Flask, render_template, request
from flask_socketio import SocketIO, emit, join_room, leave_room
from Crypto.Cipher import AES
import base64
import os
import json

app = Flask(__name__)
socketio = SocketIO(app)

# Clave para cifrado (debe ser de 16 bytes para AES)
key = os.urandom(16)

def encrypt(message):
    cipher = AES.new(key, AES.MODE_EAX)
    ciphertext, tag = cipher.encrypt_and_digest(message.encode())
    return base64.b64encode(cipher.nonce + tag + ciphertext).decode()

def decrypt(encrypted_message):
    raw = base64.b64decode(encrypted_message)
    nonce, tag, ciphertext = raw[:16], raw[16:32], raw[32:]
    cipher = AES.new(key, AES.MODE_EAX, nonce=nonce)
    return cipher.decrypt_and_verify(ciphertext, tag).decode()

users = {}

@app.route('/')
def index():
    return render_template('index.html')

@socketio.on('join')
def handle_join(data):
    username = data['username']
    users[request.sid] = username
    join_room('chat_room')
    emit('receive_message', {'username': 'Sistema', 'message': f'{username} se ha unido al chat'}, room='chat_room')

@socketio.on('disconnect')
def handle_disconnect():
    username = users.pop(request.sid, None)
    if username:
        leave_room('chat_room')
        emit('receive_message', {'username': 'Sistema', 'message': f'{username} ha salido del chat'}, room='chat_room')

@socketio.on('send_message')
def handle_send_message(data):
    encrypted_message = data['message']
    try:
        message = decrypt(encrypted_message)
        username = users.get(request.sid, 'Anónimo')
        emit('receive_message', {'username': username, 'message': message}, room='chat_room')
    except Exception as e:
        print(f"Error descifrando el mensaje: {e}")

@socketio.on('encrypt_message')
def handle_encrypt_message(data):
    message = data['message']
    encrypted_message = encrypt(message)
    emit('receive_encrypted_message', {'message': encrypted_message})

if __name__ == '__main__':
    socketio.run(app, debug=True, host='0.0.0.0', port=5000)
