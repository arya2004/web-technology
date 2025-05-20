package com.example.grocery_backend.controller;

import com.example.grocery_backend.model.Consumer;
import com.example.grocery_backend.service.AuthService;
import lombok.AllArgsConstructor;
import lombok.Data;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

@RestController
@RequestMapping("/api/auth")
@AllArgsConstructor
public class AuthController {

    private final AuthService authService;

    @PostMapping("/register")
    public ResponseEntity<RegistrationResponse> register(
        @RequestBody RegistrationRequest req) {
        Consumer user = authService.register(
            req.getName(), req.getEmail(), req.getPassword(), req.getRole());
        return ResponseEntity.status(201).body(
            new RegistrationResponse(user.getId(), user.getName(), user.getEmail(), user.getRole().name())
        );
    }

    @PostMapping("/login")
    public ResponseEntity<LoginResponse> login(
        @RequestBody LoginRequest req) {
        String token = authService.login(req.getEmail(), req.getPassword());
        // extract role from token or service? Simplest: service could return user but we skip
        // So decode to get role:
        // but for simplicity, include role in loginResponse?
        // Instead, we will return only token—you can decode role on frontend if needed.
        return ResponseEntity.ok(new LoginResponse(token));
    }

    @Data
    static class RegistrationRequest {
        private String name;
        private String email;
        private String password;
        private String role;
    }

    @Data
    static class RegistrationResponse {
        private Long id;
        private String name;
        private String email;
        private String role;
        public RegistrationResponse(Long id, String name, String email, String role) {
            this.id = id; this.name = name; this.email = email; this.role = role;
        }
    }

    @Data
    static class LoginRequest {
        private String email;
        private String password;
    }

    @Data
    static class LoginResponse {
        private String token;
        public LoginResponse(String token) { this.token = token; }
    }
}