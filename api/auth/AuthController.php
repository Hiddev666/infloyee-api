<?php

namespace Api\Auth;
use Firebase\JWT\JWT;

class AuthController
{

    private $secretKey = 'chnuwhhwfiuanhlhwnhfawucnhe';

    public function login()
    {

        include 'config.php';

        $stmt = $conn->prepare("SELECT a.nrp, a.nama, a.password, c.role FROM employees as a join user_access as b on a.nrp = b.nrp JOIN user_role as c on b.id_role = c.id_role join departements d on a.id_departemen = d.id_departemen where a.nrp=?;");
        $stmt->bind_param("s", $nrp);

        $nrp = $_POST['nrp'];

        $stmt->execute();
        $arrQuery = $stmt->get_result()->fetch_assoc();


        if(!empty($arrQuery)) {
            $nrp = $arrQuery['nrp'];
            $nama = $arrQuery['nama'];
            $role = $arrQuery['role'];
            $password = md5($_POST['password']);
            $password2 = $arrQuery['password'];

            if($password === $password2) {
                $secretKey = $this->secretKey;
                $payload = [
                    'nrp' => $nrp,
                    'nama' => $nama,
                    'role' => $role
                ];

                $jwt = JWT::encode($payload, $secretKey, 'HS256');
                echo json_encode([
                    'status' => true,
                    'message' => 'Login Success',
                    'data' => [
                        'nrp' => $nrp,
                        'nama' => $nama,
                        'token' => $jwt
                    ]
                ]);

            } else {
            http_response_code(401);
                echo json_encode([
                    'status' => 401,
                    'message' => 'Login Failed',
                ]);
            }

        } else {
            http_response_code(401);
            echo json_encode([
                'status' => 401,
                'message' => 'Login Failed',
            ]);
        }
    }


}


?>