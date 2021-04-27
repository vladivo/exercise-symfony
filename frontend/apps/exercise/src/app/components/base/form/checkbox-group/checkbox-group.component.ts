import {Component, forwardRef, Input} from '@angular/core';
import {ControlValueAccessor, NG_VALUE_ACCESSOR} from "@angular/forms";

@Component({
  selector: 'app-checkbox-group',
  templateUrl: './checkbox-group.component.html',
  providers: [
    {
      provide: NG_VALUE_ACCESSOR,
      useExisting: forwardRef(() => CheckboxGroupComponent),
      multi: true
    }
  ]
})
export class CheckboxGroupComponent implements ControlValueAccessor {
  private controlValues: unknown[] = [];
  private onControlChange!: Function;
  private onControlTouched!: Function;

  @Input() public id!: string;
  @Input() public source!: object[];
  @Input() public columns!: { label: string, value: string };

  public registerOnChange(fn: Function): void {
    this.onControlChange = fn;
  }

  public registerOnTouched(fn: Function): void {
    this.onControlTouched = fn;
  }

  public writeValue(obj: unknown[] | null): void {
    if (Array.isArray(obj)) {
      this.controlValues = obj;
    }
  }

  public isChecked(value: unknown): boolean {
    return this.controlValues.includes(value);
  }

  public onCheckedChange(event: Event, value: unknown) {
    const element: HTMLInputElement = event.target as HTMLInputElement;

    if (element.checked) {
      this.controlValues.push(value);
    } else {
      this.controlValues.splice(this.controlValues.indexOf(value), 1);
    }

    this.onControlChange(this.controlValues);
  }
}
