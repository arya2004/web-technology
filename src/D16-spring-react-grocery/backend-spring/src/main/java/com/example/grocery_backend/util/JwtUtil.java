package com.example.grocery_backend.util;
import io.jsonwebtoken.*;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.stereotype.Component;

import java.util.Date;

@Component
public class JwtUtil {

    @Value("${jwt.secret}")
    private String jwtSecret;

    @Value("${jwt.expiration-ms}")
    private long jwtExpirationMs;

    public String generateToken(Long userId, String email, String role) {
        return Jwts.builder()
            .setSubject(email)
            .claim("id", userId)
            .claim("role", role)
            .setIssuedAt(new Date())
            .setExpiration(new Date((new Date()).getTime() + jwtExpirationMs))
            .signWith(SignatureAlgorithm.HS512, jwtSecret)
            .compact();
    }

    public Jws<Claims> validateToken(String token) {
        return Jwts.parser()
            .setSigningKey(jwtSecret)
            .parseClaimsJws(token);
    }

    public String getEmailFromToken(String token) {
        return validateToken(token).getBody().getSubject();
    }

    public String getRoleFromToken(String token) {
        return (String) validateToken(token).getBody().get("role");
    }

    public Long getUserIdFromToken(String token) {
        return ((Number) validateToken(token).getBody().get("id")).longValue();
    }
}