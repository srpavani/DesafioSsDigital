import requests
import matplotlib.pyplot as plt
import random
import string

API_URL = 'http://localhost:8080/ProjetoSSdigital/DesafioSsDigital/Back-end'

def gerar_email_aleatorio():
    prefixo = ''.join(random.choices(string.ascii_lowercase + string.digits, k=10))
    dominio = 'testando.com'
    return f'{prefixo}@{dominio}'

def registrar_usuario(email, password='senha123'):
    response = requests.post(f'{API_URL}/registrar.php', json={'email': email, 'password': password})
    return response.status_code

def login_usuario(email, password='senha123'):      #para funcionar teria que ativar o login sem confirmacao de email
    response = requests.post(f'{API_URL}/login.php', json={'email': email, 'password': password})
    return response.status_code

emails = []
status_registro = []
#status_login = []

for _ in range(100):
    email = gerar_email_aleatorio()
    emails.append(email)
    status_code_registro = registrar_usuario(email)
    status_registro.append(status_code_registro)

sucesso_registro = sum(1 for status in status_registro if status == 200)
falha_registro = 100 - sucesso_registro
#sucesso_login = sum(1 for status in status_login if status == 200)
#falha_login = 100 - sucesso_login

plt.figure(figsize=(10, 5))
plt.bar(['Sucesso', 'Falha'], [sucesso_registro, falha_registro], color=['green', 'red'])
plt.title('Resultado dos Testes de Registro')
plt.ylabel('Número de Emails')
plt.savefig('registro_resultados.png')
plt.show()


#plt.figure(figsize=(10, 5))
#plt.bar(['Sucesso', 'Falha'], [sucesso_login, falha_login], color=['blue', 'orange'])
#plt.title('Resultado dos Testes de Login')
#plt.ylabel('Número de Emails')
#plt.savefig('login_resultados.png')
#plt.show()

print(f"Emails registrados com sucesso: {sucesso_registro}/100")

