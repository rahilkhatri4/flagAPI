<?php

class User {
    private $id;
    private $name;
    private $gender;
    private $age;
    private $birthdate;
    private $email;
    private $passwordHash;
    private $bio;
    private $profilePicture;
    private $campus;
    private $preferredGender;
    private $fromAge;
    private $toAge;

    // Getter and Setter methods for each property

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getGender() {
        return $this->gender;
    }

    public function setGender($gender) {
        $this->gender = $gender;
    }

    public function getAge() {
        return $this->age;
    }

    public function setAge($age) {
        $this->age = $age;
    }

    public function getBirthdate() {
        return $this->birthdate;
    }

    public function setBirthdate($birthdate) {
        $this->birthdate = $birthdate;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getPasswordHash() {
        return $this->passwordHash;
    }

    public function setPasswordHash($passwordHash) {
        $this->passwordHash = $passwordHash;
    }

    public function getBio() {
        return $this->bio;
    }

    public function setBio($bio) {
        $this->bio = $bio;
    }

    public function getProfilePicture() {
        return $this->profilePicture;
    }

    public function setProfilePicture($profilePicture) {
        $this->profilePicture = $profilePicture;
    }

    public function getCampus() {
        return $this->campus;
    }

    public function setCampus($campus) {
        $this->campus = $campus;
    }

    public function getPreferredGender() {
        return $this->preferredGender;
    }

    public function setPreferredGender($preferredGender) {
        $this->preferredGender = $preferredGender;
    }

    public function getFromAge() {
        return $this->fromAge;
    }

    public function setFromAge($fromAge) {
        $this->fromAge = $fromAge;
    }

    public function getToAge() {
        return $this->toAge;
    }

    public function setToAge($toAge) {
        $this->toAge = $toAge;
    }

    // Constructor

    public function __construct($id, $name, $gender, $age, $birthdate, $email, $passwordHash, $bio, $profilePicture, $campus, $preferredGender, $fromAge, $toAge) {
        $this->id = $id;
        $this->name = $name;
        $this->gender = $gender;
        $this->age = $age;
        $this->birthdate = $birthdate;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
        $this->bio = $bio;
        $this->profilePicture = $profilePicture;
        $this->campus = $campus;
        $this->preferredGender = $preferredGender;
        $this->fromAge = $fromAge;
        $this->toAge = $toAge;
    }
}

?>
