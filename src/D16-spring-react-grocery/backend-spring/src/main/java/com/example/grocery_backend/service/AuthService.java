package com.example.grocery_backend.service;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.stereotype.Service;

import com.example.grocery_backend.model.Consumer;
import com.example.grocery_backend.model.Role;
import com.example.grocery_backend.repository.ConsumerRepository;
import com.example.grocery_backend.util.JwtUtil;

import java.util.Optional;

@Service
public class AuthService {

    @Autowired private ConsumerRepository consumerRepo;
    @Autowired private PasswordEncoder passwordEncoder;
    @Autowired private JwtUtil jwtUtil;

    public Consumer register(String name, String email, String rawPassword, String roleStr) {
        if (consumerRepo.existsByEmail(email)) {
            throw new RuntimeException("Email already in use");
        }
        Role role = Role.valueOf(roleStr.toUpperCase());
        Consumer user = new Consumer(name, email,
            passwordEncoder.encode(rawPassword), role);
        return consumerRepo.save(user);
    }

    public String login(String email, String rawPassword) {
        Optional<Consumer> opt = consumerRepo.findByEmail(email);
        if (opt.isEmpty() || !passwordEncoder.matches(rawPassword, opt.get().getPassword())) {
            throw new RuntimeException("Invalid credentials");
        }
        Consumer user = opt.get();
        return jwtUtil.generateToken(user.getId(), user.getEmail(), user.getRole().name());
    }
}