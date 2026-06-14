<?php

class Conexao {

    private static $instancia = null;

    public static function getConexao(): PDO {

        if (self::$instancia === null) {

            $host    = 'localhost';
            $banco   = 'cinerodeio';
            $usuario = 'root';

            $senhas = ['', 'root', '1234', 'admin', 'mysql'];

            $conectado = false;

            foreach ($senhas as $senha) {
                try {
                    $dsn = "mysql:host=$host;port=3307;dbname=$banco;charset=utf8";
                    self::$instancia = new PDO($dsn, $usuario, $senha);
                    self::$instancia->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $conectado = true;
                    break;
                } catch (PDOException $e) {
                    self::$instancia = null;
                    continue;
                }
            }

            if (!$conectado) {
                die("
                    <div style='font-family:sans-serif;background:#1a1a1a;color:#f0f0f0;padding:2rem;border-left:4px solid #e50914;margin:2rem;border-radius:4px'>
                        <h2 style='color:#e50914'>Erro de conexao com o banco</h2>
                        <p>Nao foi possivel conectar com o MySQL usando as senhas padrao.</p>
                        <p>Abra o arquivo <strong>app/model/Conexao.php</strong> e adicione sua senha na lista <code>\$senhas</code>.</p>
                    </div>
                ");
            }
        }

        return self::$instancia;
    }
}
