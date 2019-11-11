import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse, HttpParams } from '@angular/common/http';

import { Observable, throwError } from 'rxjs';
import { map, catchError } from 'rxjs/operators';

import { Task } from './task';

@Injectable({
  providedIn: 'root' 
})
export class TaskService {
  baseUrl = 'http://localhost/face_4_crud/1/backend/api';
  tasks: Task[];

constructor(private http: HttpClient) { }

  getAll(): Observable<Task[]> {
    return this.http.get(`${this.baseUrl}/list`).pipe(
      map((res) => {
        this.tasks = res['data'];
        return this.tasks;
    }),
    catchError(this.handleError));
  }

  store(task: Task): Observable<Task[]> {
    return this.http.post(`${this.baseUrl}/store`, { data: task })
      .pipe(map((res) => {
        this.tasks.push(res['data']);
        return this.tasks;
      }),
      catchError(this.handleError));
  }

  update(task: Task): Observable<Task[]> {
    return this.http.put(`${this.baseUrl}/update`, { data: task })
      .pipe(map((res) => {
        const theTask = this.tasks.find((item) => {
          return +item['id'] === +task['id'];
        });
        if (theTask) {
          theTask['title'] = task['title'];
          theTask['description'] = task['description'];
        }
        return this.tasks;
      }),
      catchError(this.handleError));
  }

  delete(id: number): Observable<Task[]> {
    const params = new HttpParams()
      .set('id', id.toString());

    return this.http.delete(`${this.baseUrl}/delete`, { params: params })
      .pipe(map(res => {
        const filteredTask = this.tasks.filter((task) => {
          return +task['id'] !== +id;
        });
        return this.tasks = filteredTask;
      }),
      catchError(this.handleError));
  }

  private handleError(error: HttpErrorResponse) {
    console.log(error);

    // return an observable with a user friendly message
    return throwError('Error! something went wrong.');
  }
}
