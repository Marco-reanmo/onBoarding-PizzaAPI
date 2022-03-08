<?php
    class Users extends Controller {
        
        private $userModel;
        
        public function __construct() {
            $this->userModel = $this->loadModel('User');
        }

        public function index() {
            redirect('users/login');
        }

        public function register() {
            if(isPostRequest()) {
                $post_data = getSanitizedPostData();
                $this->processRegisterForm($post_data);
            } else {
                $data = $this->initRegisterData();
                $this->loadView('users/register', $data);    
            }
        }

        private function processRegisterForm($post_data) {
            $data = $this->initRegisterDataWith(
                trim($post_data['name']),
                trim($post_data['email']),
                trim($post_data['password']),
                trim($post_data['confirm_password']),
                trim($post_data['postal_code']),
                trim($post_data['city']),
                trim($post_data['street']),
                trim($post_data['house_number'])
            );
            $validatedData = $this->validateRegisterData($data);
            if($this->registerDataHasNoErrors($validatedData)) {
                $result = $this->userModel->register($validatedData);
                if(!is_null($result)) {
                    flash('register_success', 'Registrierung erfolgreich.');
                    header('Location: ' . URLROOT . 'users/login');
                } else {
                    die('Ein unerwarteter Fehler ist aufgetreten');
                }
            } else {
                $this->loadView('users/register', $validatedData);
            }
        }

        private function initRegisterDataWith(
            $name, 
            $email, 
            $password, 
            $confirm_password, 
            $postal_code,
            $city,
            $street,
            $house_number
            ) {
            return [
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'confirm_password' => $confirm_password,
                'postal_code' => $postal_code,
                'city' => $city,
                'street' => $street,
                'house_number' => $house_number,
                'name_error' => '',
                'email_error' => '',
                'password_error' => '',
                'confirm_password_error' => '',
                'postal_code_error' => '',
                'city_error' => '',
                'street_error' => '',
                'house_number_error' => ''      
              ];
        }

        private function validateRegisterData($data) {
            $data['name_error'] = $this->validateName($data['name']);
            $data['email_error'] = $this->validateRegistratedEmail($data['email']);
            $data['password_error'] = $this->validateRegistratedPassword($data['password']);
            $data['confirm_password_error'] = $this->validateConfirmPassword($data['password'], $data['confirm_password']);
            $data['postal_code_error'] = $this->validatePostalCode($data['postal_code']);
            $data['city_error'] = $this->validateCity($data['city']);
            $data['street_error'] = $this->validateStreet($data['street']);
            $data['house_number_error'] = $this->validateHouseNumber($data['house_number']);
            return $data; 
        }

        private function validateName($name) {
            if(empty($name)) {
                return 'Bitte einen Namen eingeben';
            } else {
                return '';
            }
        }

        private function validateRegistratedEmail($email) {
            if(empty($email)) {
                return 'Bitte eine E-Mail Adresse eingeben';
            } elseif($this->userModel->emailIsTaken($email)) {
                return 'Es existiert bereits ein Konto mit dieser E-Mail';
            } else {
                return '';
            }
        }

        private function validateRegistratedPassword($password) {
            if(empty($password)) {
                return 'Bitte ein Passwort eingeben';
            } elseif (strlen($password) < 6) {
                return 'Passwort muss mindestens 6 Zeichen lang sein.';
            } else {
                return '';
            }
        }

        private function validateConfirmPassword($password, $confirm_password) {
            if(empty($confirm_password)) {
                return 'Bitte das Passwort bestätigen';
            } else {
                if($password != $confirm_password) {
                    return 'Passwörter stimmen nicht überein.';
                } else {
                    return '';
                }
            }
        }

        private function validatePostalCode($postal_code) {
            if(empty($postal_code)) {
                return 'Bitte eine PLZ eingeben';
            } else {
                return '';
            }
        }

        private function validateCity($city) {
            if(empty($city)) {
                return 'Bitte einen Ort angeben';
            } else {
                return '';
            }
        }

        private function validateStreet($street) {
            if(empty($street)) {
                return 'Bitte eine Straße eingeben';
            } else {
                return '';
            }
        }

        private function validateHouseNumber($house_number) {
            if(empty($house_number)) {
                return 'Bitte eine Hausnummer angeben';
            } else {
                if(strlen($house_number) > 4) {
                    return 'Hausnummer zu lang (max. 4 Zeichen).';
                } else {
                    return '';
                }
            }
        }

        private function registerDataHasNoErrors($data) {
            return empty($data['name_error']) 
                && empty($data['email_error']) 
                && empty($data['password_error']) 
                && empty($data['confirm_password_error'])
                && empty($data['postal_code_error'])
                && empty($data['city_error'])
                && empty($data['street_error'])
                && empty($data['house_number_error']);
        }

        private function initRegisterData() {
            return [
              'name' => '',
              'email' => '',
              'password' => '',
              'confirm_password' => '',
              'postal_code' => '',
              'city' => '',
              'street' => '',
              'house_number' => '',
              'name_error' => '',
              'email_error' => '',
              'password_error' => '',
              'confirm_password_error' => '',
              'postal_code_error' => '',
              'city_error' => '',
              'street_error' => '',
              'house_number_error' => ''           
            ];
        }

        public function login() {
            if(isPostRequest()) {
                $post_data = getSanitizedPostData();
                $this->processLoginForm($post_data);
            } else {
                $data = $this->initLoginData();
                $this->loadView('users/login', $data);    
            }
        }

        private function processLoginForm($post_data) {
            $data = $this->initLoginDataWith(
                trim($post_data['email']),
                trim($post_data['password'])
            );
            $validatedData = $this->validateLoginData($data);
            if($this->loginDataHasNoErrors($validatedData)) {
                $loggedInUser = $this->userModel->login($validatedData['email'], $validatedData['password']);
                if($loggedInUser) {
                    $this->createUserSession(
                        $loggedInUser->ID,
                        $loggedInUser->email,
                        $loggedInUser->name
                    );
                    redirect('products/index');
                } else {
                    $validatedData['email_error'] = 'Fehler bei der Anmeldung';
                    $this->loadView('users/login', $validatedData);
                }
            } else {
                $this->loadView('users/login', $validatedData);
            }
        }

        private function initLoginDataWith($email, $password) {
            return [
                'email' => $email,
                'password' => $password,
                'email_error' => '',
                'password_error' => ''      
              ];
        }

        private function validateLoginData($data) {
            $data['email_error'] = $this->validateLoginEmail($data['email']);
            $data['password_error'] = $this->validateLoginPassword($data['password']);
            return $data; 
        }

        private function validateLoginEmail($email) {
            if(empty($email)) {
                return 'Bitte eine E-Mail Adresse eingeben';
            } elseif(!$this->userModel->findUserByEmail($email)) {
                return 'Fehler bei der Anmeldung';
            } else {
                return '';
            }
        }

        private function validateLoginPassword($password) {
            if(empty($password)) {
                return 'Bitte ein Passwort eingeben';
            } elseif (strlen($password) < 6) {
                return 'Passwort muss mindestens 6 Zeichen lang sein.';
            } else {
                return '';
            }
        }

        private function loginDataHasNoErrors($data) {
            return empty($data['email_error']) && empty($data['password_error']);
        }


        private function initLoginData() {
            return [
              'email' => '',
              'password' => '',
              'email_error' => '',
              'password_error' => ''
            ];
        }

        private function createUserSession($id, $email, $name) {
            $_SESSION['user_id'] = $id;
            $_SESSION['user_email'] = $email;
            $_SESSION['user_name'] = $name;
        }

        public function logout() {
            unset($_SESSION['user_id']);
            unset($_SESSION['user_email']);
            unset($_SESSION['user_name']);
            session_destroy();
            redirect('users/login');
        }

        public function profile() {
            if(isLoggedIn()) {
                if(isPostRequest()) {
                    $post = getSanitizedPostData();
                    $this->processProfileForm($post);
                }
                
                $user = $this->userModel->getUserById($_SESSION['user_id']);
                $data = $this->initProfileDataWith(
                    $user->name,
                    $user->email,
                    '',
                    '',
                    '',
                    $user->postalCode,
                    $user->city,
                    $user->street,
                    $user->houseNumber
                );
                $data['title'] = 'Profil';
                $this->loadView('users/profile', $data);  
            } else {
                redirect('users/login');
            };
        }

        private function processProfileForm($post_data) {
            $data = $this->initProfileDataWith(
                trim($post_data['name']),
                trim($post_data['email']),
                trim($post_data['old_password']),
                trim($post_data['new_password']),
                trim($post_data['confirm_password']),
                trim($post_data['postal_code']),
                trim($post_data['city']),
                trim($post_data['street']),
                trim($post_data['house_number'])
            );
            $validatedData = $this->validateProfileData($data);
            $validatedData['title'] = 'Profil';
            if($this->profileDataHasNoErrors($validatedData)) {
                $validatedData['user_id'] = $_SESSION['user_id'];
                $result = $this->userModel->update($validatedData);
                if(!is_null($result)) {
                    flash('update_success', 'Update erfolgreich.');
                    $this->loadView('users/profile', $validatedData);
                } else {
                    die('Ein unerwarteter Fehler ist aufgetreten');
                }
            } else {
                $this->loadView('users/profile', $validatedData);
            }
        }

        private function validateProfileData($data) {
            $data['name_error'] = $this->validateName($data['name']);
            $data['email_error'] = $this->validateProfilEmail($data['email']);
            $data['old_password_error'] = $this->validateOldPassword($data['old_password']);
            $data['new_password_error'] = $this->validateRegistratedPassword($data['new_password']);
            $data['confirm_password_error'] = $this->validateConfirmPassword($data['new_password'], $data['confirm_password']);
            $data['postal_code_error'] = $this->validatePostalCode($data['postal_code']);
            $data['city_error'] = $this->validateCity($data['city']);
            $data['street_error'] = $this->validateStreet($data['street']);
            $data['house_number_error'] = $this->validateHouseNumber($data['house_number']);
            return $data; 
        }

        private function validateProfilEmail($email) {
            if(empty($email)) {
                return 'Bitte eine E-Mail Adresse eingeben';
            } elseif($this->userModel->emailIsTaken($email)) {
                $user = $this->userModel->getUserById($_SESSION['user_id']);
                if($user->email == $email) {
                    return '';
                }
                return 'Es existiert bereits ein Konto mit dieser E-Mail';
            } else {
                return '';
            }
        }

        private function validateOldPassword($old_password) {
            if(empty($old_password)) {
                return 'Bitte das Alte Password eingeben';
            } 
            $user = $this->userModel->getUserById($_SESSION['user_id']);
            if(password_verify($old_password, $user->password)) {
                return '';
            }    
            return 'Das alte Passwort stimmt nicht überein';
        }

        private function profileDataHasNoErrors($data) {
            return empty($data['name_error']) 
                && empty($data['email_error']) 
                && empty($data['old_password_error'])
                && empty($data['new_password_error']) 
                && empty($data['confirm_password_error'])
                && empty($data['postal_code_error'])
                && empty($data['city_error'])
                && empty($data['street_error'])
                && empty($data['house_number_error']);
        }

        private function initProfileDataWith(
            $name, 
            $email, 
            $oldPassword,
            $newPassword, 
            $confirm_password, 
            $postal_code,
            $city,
            $street,
            $house_number
            ) {
            return [
                'name' => $name,
                'email' => $email,
                'old_password' => $oldPassword,
                'new_password' => $newPassword,
                'confirm_password' => $confirm_password,
                'postal_code' => $postal_code,
                'city' => $city,
                'street' => $street,
                'house_number' => $house_number,
                'name_error' => '',
                'email_error' => '',
                'old_password_error' => '',
                'new_password_error' => '',
                'confirm_password_error' => '',
                'postal_code_error' => '',
                'city_error' => '',
                'street_error' => '',
                'house_number_error' => ''      
              ];
        }
    }
