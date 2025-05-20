package com.example.grocery_backend.repository;


import com.example.grocery_backend.model.Consumer;
import java.util.Optional;
import org.springframework.data.jpa.repository.JpaRepository;

public interface ConsumerRepository extends JpaRepository<Consumer, Long> {
    Optional<Consumer> findByEmail(String email);
    boolean existsByEmail(String email);
}