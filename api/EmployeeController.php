<?php

namespace Api;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class EmployeeController
{

    private $secretKey = 'chnuwhhwfiuanhlhwnhfawucnhe';

    public function index()
    {

        // $header = getallheaders();
        // if(!isset($header['Authorization'])) {
        //     http_response_code(401);
        //     echo json_encode([
        //         'status' => false,
        //         'message' => 'Unauthenticated'
        //     ]);
        //     exit();
        // }

        require_once('config.php');

        // $headers = getallheaders();

        // try {
        // $secretKey = $this->secretKey;
        // list(, $token) = explode(' ', $headers['Authorization']);

        // $jwtDecoded = JWT::decode($token, new Key($secretKey, 'HS256'));

        $query = "SELECT a.nrp, a.nama, a.jabatan, b.nama_departemen, a.tanggal_lahir, a.alamat, a.email, a.no_telepon, a.role, a.avatar FROM employees a join departements b on a.id_departemen = b.id_departemen;";
        $sql = mysqli_query($conn, $query);
        $data = [];
        while ($row = mysqli_fetch_assoc($sql)) {
            $data[] = $row;
        }

        if (count($data) <= 0) {
            echo json_encode([
                'status' => true,
                'message' => 'Data Not Found'
            ]);
        } else {
            echo json_encode([
                'status' => true,
                'message' => 'Data Get Success',
                'data' => $data
            ]);
        }
        // } catch (Exception $e) {
        //     echo $e;
        // }

    }

    public function show($nrp)
    {
        $header = getallheaders();
        if (!isset($header['Authorization'])) {
            http_response_code(401);
            echo json_encode([
                'status' => false,
                'message' => 'Unauthenticated'
            ]);
            exit();
        }

        require_once('config.php');

        $headers = getallheaders();

        try {
            $secretKey = $this->secretKey;
            list(, $token) = explode(' ', $headers['Authorization']);

            $jwtDecoded = JWT::decode($token, new Key($secretKey, 'HS256'));

            // Query
            $query = "SELECT a.nrp, a.nama, a.jabatan, b.nama_departemen, a.tanggal_lahir, a.alamat, a.email, a.no_telepon, a.role FROM employees a join departements b on a.id_departemen = b.id_departemen where nrp='$nrp';";

            $sql = mysqli_query($conn, $query);
            $data = [];
            while ($row = mysqli_fetch_assoc($sql)) {
                $data[] = $row;
            }

            if (count($data) <= 0) {
                echo json_encode([
                    'status' => false,
                    'message' => 'Data Not Found',
                ]);
                http_response_code(404);
            } else {
                echo json_encode([
                    'status' => true,
                    'message' => 'Data Get Success',
                    'data' => $data
                ]);
            }

        } catch (Exception $e) {
            echo $e;
        }
    }

    public function insert()
    {
        require_once('config.php');

        $header = getallheaders();
        if (!isset($header['Authorization'])) {
            http_response_code(401);
            echo json_encode([
                'status' => false,
                'message' => 'Unauthenticated'
            ]);
            exit();
        }


        $headers = getallheaders();
        $secretKey = $this->secretKey;
        list(, $token) = explode(' ', $headers['Authorization']);

        $jwtDecoded = JWT::decode($token, new Key($secretKey, 'HS256'));
        $arr = ((array) $jwtDecoded);

        if ($arr['role'] == 'admin') {
            try {
                // Query
                $targetDirectory = './images/';
                $allowedFileTypes = array("jpg", "jpeg", "png", "gif");
                $maxFileSize = 500000;

                if (isset($_FILES["avatar"])) {
                    $targetFile = $targetDirectory . basename($_FILES["avatar"]["name"]);
                    $uploadOk = 1;
                    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

                    // Try to upload the file
                    if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $targetFile)) {
                        $stmt = $conn->prepare("INSERT INTO employees VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                        $stmt->bind_param("sssssssssss", $nrp, $nama, $jabatan, $tanggal_lahir, $alamat, $email, $no_telepon, $role, $id_departemen, $image, $password);

                        $nrp = $_POST['nrp'];
                        $nama = $_POST['nama'];
                        $jabatan = $_POST['jabatan'];
                        $tanggal_lahir = $_POST['tanggal_lahir'];
                        $alamat = $_POST['alamat'];
                        $email = $_POST['email'];
                        $no_telepon = $_POST['no_telepon'];
                        $role = $_POST['role'];
                        $id_departemen = $_POST['id_departemen'];
                        $image = $_SERVER["SERVER_NAME"] . "/infloyee/images/" . basename($_FILES["avatar"]["name"]);
                        $password = md5($_POST['password']);

                        $stmt->execute();

                        if (!$stmt) {
                            echo json_encode([
                                'status' => false,
                                'message' => 'Insert Data Failed',
                            ]);
                            http_response_code(400);
                        } else {
                            echo json_encode([
                                'status' => true,
                                'message' => 'Insert Data Success',
                            ]);
                            http_response_code(201);
                        }

                        $stmt->close();
                    } else {
                        return "Error: There was an error uploading your file.";
                    }
                } else {
                    return "Error: No file selected for upload.";
                }
            } catch (Exception $e) {
                echo "asd";
            }
        } else {
            http_response_code(403);
            echo json_encode([
                'status' => false,
                'message' => 'You dont have permission'
            ]);
        }
    }

    public function update($nrp)
    {
        require_once('config.php');

        $header = getallheaders();
        if (!isset($header['Authorization'])) {
            http_response_code(401);
            echo json_encode([
                'status' => false,
                'message' => 'Unauthenticated'
            ]);
            exit();
        }

        $headers = getallheaders();
        $secretKey = $this->secretKey;
        list(, $token) = explode(' ', $headers['Authorization']);

        $jwtDecoded = JWT::decode($token, new Key($secretKey, 'HS256'));
        $arr = ((array) $jwtDecoded);

        if ($arr['role'] == 'admin') {
            try {
                // Query
                $stmt = $conn->prepare("UPDATE employees SET nama=?, jabatan=?, tanggal_lahir=?, alamat=?, email=?, no_telepon=?, role=?, id_departemen=? where nrp='$nrp';");
                $stmt->bind_param("ssssssss", $nama, $jabatan, $tanggal_lahir, $alamat, $email, $no_telepon, $role, $id_departemen);

                $nama = $_POST['nama'];
                $jabatan = $_POST['jabatan'];
                $tanggal_lahir = $_POST['tanggal_lahir'];
                $alamat = $_POST['alamat'];
                $email = $_POST['email'];
                $no_telepon = $_POST['no_telepon'];
                $role = $_POST['role'];
                $id_departemen = $_POST['id_departemen'];

                $stmt->execute();

                if (!$stmt) {
                    echo json_encode([
                        'status' => false,
                        'message' => 'Data Update Failed',
                    ]);
                    http_response_code(400);
                } else {
                    echo json_encode([
                        'status' => true,
                        'message' => 'Data Update Success',
                    ]);
                    http_response_code(201);
                }

                $stmt->close();
            } catch (Exception $e) {
                echo $e;
            }

        } else {
            http_response_code(403);
            echo json_encode([
                'status' => false,
                'message' => 'You dont have permission'
            ]);
        }
    }

    public function delete($nrp)
    {
        require_once('config.php');

        $header = getallheaders();
        if (!isset($header['Authorization'])) {
            http_response_code(401);
            echo json_encode([
                'status' => false,
                'message' => 'Unauthenticated'
            ]);
            exit();
        }


        $headers = getallheaders();
        $secretKey = $this->secretKey;
        list(, $token) = explode(' ', $headers['Authorization']);

        $jwtDecoded = JWT::decode($token, new Key($secretKey, 'HS256'));
        $arr = ((array) $jwtDecoded);

        if($arr['role'] == 'admin') {
                    try {
            
                        // Query
                        $stmt = $conn->prepare("DELETE FROM employees where nrp='$nrp';");
                        $stmt->execute();
            
                        if (!$stmt) {
                            echo json_encode([
                                'status' => false,
                                'message' => 'Data Delete Failed',
                            ]);
                            http_response_code(400);
                        } else {
                            echo json_encode([
                                'status' => true,
                                'message' => 'Data Delete Success',
                            ]);
                            http_response_code(201);
                        }
            
                        $stmt->close();
                    } catch (Exception $e) {
                        echo $e;
                    }
                } else {
                    http_response_code(403);
                    echo json_encode([
                        'status' => false,
                        'message' => 'You dont have permission'
                    ]);
                }

        }
}


?>